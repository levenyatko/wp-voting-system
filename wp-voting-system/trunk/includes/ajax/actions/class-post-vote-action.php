<?php
/**
 * Post vote action callback.
 *
 * @package WP_Voting_System\AJAX\Actions
 */

namespace WP_Voting_System\AJAX\Actions;

use WP_Voting_System\Interfaces\AJAX_Action_Interface;
use WP_Voting_System\Models\User;
use WP_Voting_System\Models\Vote;

defined( 'ABSPATH' ) || exit;

/**
 * Class Post_Vote_Action
 */
class Post_Vote_Action implements AJAX_Action_Interface {

	/**
	 * Is action public.
	 *
	 * @var boolean $is_public
	 */
	public $is_public = true;

	/**
	 * Action name.
	 *
	 * @var string $action_name
	 */
	public $action_name = 'wpvs-vote';

	/**
	 * Action callback function.
	 *
	 * @return mixed
	 */
	public function callback() {
		$response = array( 'success' => false );

		if ( ! empty( $_REQUEST['nonce'] ) && ! empty( $_REQUEST['id'] ) && isset( $_REQUEST['is_positive'] ) ) {
			// check nonce.
			$nonce_value = sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) );
			if ( wp_verify_nonce( $nonce_value, $this->action_name ) ) {

				// check post id.
				$post_id = intval( $_REQUEST['id'] );
				$post    = get_post( $post_id );
				if ( ! empty( $post ) ) {

					// if post type is in allowed list.
					$allowed_post_types = apply_filters( 'wpvs_show_voting_post_types', array( 'post' ) );
					if ( in_array( $post->post_type, $allowed_post_types, true ) ) {

						$current_user = new User();
						$current_user->set_current();

						if ( ! $current_user->voted( $post->ID ) ) {

							$create_data = array(
								'post_id'     => $post->ID,
								'user_id'     => $current_user->user_id,
								'user_ip'     => $current_user->ip,
								'is_positive' => boolval( $_REQUEST['is_positive'] ),
							);
							$created     = Vote::create( $create_data );

							if ( $created ) {
								$response['success'] = true;
								$response['html']    = apply_filters( 'wpvs_voting_block_ajax_html', '', $create_data );
							}
						}
					}
				}
			}
		}

		wp_send_json( $response );
	}
}
