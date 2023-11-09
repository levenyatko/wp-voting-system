<?php
/**
 * Post metabox with voting statistic.
 *
 * @package WP_Voting_System\Admin\Metaboxes
 */

namespace WP_Voting_System\Admin\Metaboxes;

use WP_Voting_System\Interfaces\Actions_Interface;
use WP_Voting_System\Interfaces\Metabox_Interface;
use WP_Voting_System\Models\Vote;

defined( 'ABSPATH' ) || exit;

/**
 * Class Post_Voting_Report_Metabox
 */
class Post_Voting_Report_Metabox implements Metabox_Interface, Actions_Interface {

	/**
	 * Return the actions to register.
	 *
	 * @return array
	 */
	public function get_actions() {
		return array(
			'add_meta_boxes' => array( 'register' ),
		);
	}

	/**
	 * Metabox register function.
	 *
	 * @return void
	 */
	public function register() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$screens = apply_filters( 'wpvs_show_voting_post_types', array( 'post' ) );

		if ( ! empty( $screens ) ) {

			add_meta_box(
				'wpvs_voting_report',
				__( 'Votings', 'wp-voting-system' ),
				array( $this, 'display' ),
				$screens,
				'side',
				'low'
			);
		}
	}

	/**
	 * Get current screen post ID.
	 *
	 * @return int|null
	 */
	private function get_post_id() {
		$post_id = null;

		if ( isset( $_GET['post'] ) ) {
			$post_id = intval( $_GET['post'] );
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = intval( $_POST['post_ID'] );
		}

		return $post_id;
	}

	/**
	 * Metabox display function.
	 *
	 * @return void
	 */
	public function display() {
		$post_id = $this->get_post_id();
		if ( empty( $post_id ) ) {
			return;
		}

		$positive = Vote::get_positive_stat( $post_id );
		$negative = Vote::get_negative_stat( $post_id );
		$args     = array(
			'positive' => $positive,
			'negative' => $negative,
		);
		include 'views/post-voting-report.php';
	}
}
