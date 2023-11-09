<?php
	/**
	 * User model.
	 *
	 * @package WP_Voting_System\Models
	 */

	namespace WP_Voting_System\Models;

	use WP_Voting_System\Interfaces\Model_Interface;
	use WP_Voting_System\Utils\Userdata_Util;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class User
	 */
class User implements Model_Interface {

	/**
	 * Current user ID.
	 *
	 * @var int $user_id
	 */
	public $user_id;

	/**
	 * Current user IP.
	 *
	 * @var string $ip
	 */
	public $ip;

	/**
	 * Set user to current.
	 *
	 * @return void
	 */
	public function set_current() {
		$this->user_id = get_current_user_id();
		$this->ip      = Userdata_Util::get_hashed_ip();
	}

	/**
	 * Get usser vote for post.
	 *
	 * @param int $post_id Post ID to filter user votes.
	 *
	 * @return array
	 */
	public function get_user_vote( $post_id ) {
		$votes = Vote::find(
			array(
				'ip'      => $this->ip,
				'post_id' => $post_id,
			),
			1
		);

		if ( ! empty( $votes[0] ) ) {
			return $votes[0];
		}

		return array();
	}

	/**
	 * Check if user voted for the post.
	 *
	 * @param int $post_id Post to check.
	 *
	 * @return boolean
	 */
	public function voted( $post_id ) {

		$user_votes = $this->get_user_vote( $post_id );

		return ( ! empty( $user_votes ) );
	}
}
