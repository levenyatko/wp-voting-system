<?php
/**
 * Voting block display.
 *
 * @package WP_Voting_System\Front
 */

namespace WP_Voting_System\Front;

use WP_Voting_System\Interfaces\Filters_Interface;
use WP_Voting_System\Models\User;
use WP_Voting_System\Models\Vote;
use WP_Voting_System\Utils\Global_Util;
use WP_Voting_System\Utils\Template_Util;

defined( 'ABSPATH' ) || exit;

/**
 * Class Voting_Block
 */
class Voting_Block implements Filters_Interface {

	/**
	 * Current plugin version.
	 *
	 * @var string $version
	 */
	private $version;

	/**
	 * Class construct.
	 *
	 * @param string $version Current front-end version.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Return the filters to register.
	 *
	 * @return array
	 */
	public function get_filters() {
		return array(
			'the_content'                 => array( 'display', 100 ),
			'wp_enqueue_scripts'          => array( 'enqueue', 100 ),
			'wpvs_voting_block_ajax_html' => array( 'get_block', 10, 2 ),
		);
	}

	/**
	 * Is voting block visible on the page.
	 *
	 * @return bool
	 */
	public function is_block_visible() {
		$screens = apply_filters( 'wpvs_show_voting_post_types', array( 'post' ) );
		if ( is_singular( $screens ) && is_main_query() ) {
			return true;
		}
		return false;
	}

	/**
	 * Get voting block.
	 *
	 * @param string $content Old block content.
	 * @param array  $args Passed args.
	 *
	 * @return string
	 */
	public function get_block( $content, $args ) {
		if ( empty( $args['post_id'] ) ) {
			return '';
		}
		return $this->get_voting_block( $args['post_id'] );
	}

	/**
	 * Get voting block for the post.
	 *
	 * @param int $post_id Post ID to get block.
	 *
	 * @return string
	 */
	private function get_voting_block( $post_id ) {
		$current_user = new User();
		$current_user->set_current();

		$is_voted = $current_user->voted( $post_id );

		if ( $is_voted ) {
			$text = Global_Util::get_option( 'thank_you_text', 'wpvs_voting_block' );
		} else {
			$text = Global_Util::get_option( 'text', 'wpvs_voting_block' );
		}

		$args = array(
			'text'  => $text,
			'voted' => $is_voted,
		);

		if ( $is_voted ) {
			$args['positive'] = Vote::get_positive_stat( $post_id );
			$args['negative'] = 100 - $args['positive'];

			$user_post_vote = $current_user->get_user_vote( $post_id );
			if ( ! empty( $user_post_vote ) ) {
				if ( 0 > $user_post_vote['vote'] ) {
					$args['voted_positive'] = false;
				} else {
					$args['voted_positive'] = true;
				}
			}
		}

		return Template_Util::get_template_html( 'voting-block', 'public', $args );
	}

	/**
	 * Maybe add voting block after post content.
	 *
	 * @param string $content Post content.
	 *
	 * @return mixed|string
	 */
	public function display( $content ) {
		global $post;

		if ( $this->is_block_visible() ) {
			$content .= '<div class="wpvs-voting-block" data-post="' . esc_attr( $post->ID ) . '">';
			$content .= $this->get_voting_block( $post->ID );
			$content .= '</div>';
		}

		return $content;
	}

	/**
	 * Enqueue block styles and scripts.
	 *
	 * @return void
	 */
	public function enqueue() {
		if ( $this->is_block_visible() ) {
			wp_enqueue_style( 'wpvs-style', WP_VS_PLUGIN_URL . 'assets/css/style.css', false, $this->version );

			wp_register_script( 'wpvs-script', WP_VS_PLUGIN_URL . 'assets/js/script.js', false, $this->version, true );
			wp_localize_script(
				'wpvs-script',
				'wpvsVars',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'wpvs-vote' ),
				)
			);
			wp_enqueue_script( 'wpvs-script' );

		}
	}
}
