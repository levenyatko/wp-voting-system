<?php
	/**
	 * Vote model.
	 *
	 * @package WP_Voting_System\Models
	 */

	namespace WP_Voting_System\Models;

	use WP_Voting_System\Interfaces\Model_Interface;
	use WP_Voting_System\Utils\DB_Table_Util;
	use WP_Voting_System\Utils\Userdata_Util;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Vote
	 */
class Vote implements Model_Interface {

	/**
	 * Create new Vote.
	 *
	 * @param array $data Data to create new Vote.
	 *
	 * @return boolean
	 */
	public static function create( $data ) {

		if ( ! empty( $data['post_id'] ) && isset( $data['is_positive'] ) ) {

			$insert_data = array(
				'post_id' => $data['post_id'],
				'user_id' => ( isset( $data['user_id'] ) ) ? $data['user_id'] : 0,
				'vote'    => ( empty( $data['is_positive'] ) ) ? -1 : 1,
				'user_ip' => ( isset( $data['user_ip'] ) ) ? $data['user_ip'] : Userdata_Util::get_hashed_ip(),
				'time'    => current_time( 'mysql' ),
			);

			$table  = DB_Table_Util::get_votes_table();
			$result = $table->insert( $insert_data );

			return (bool) $result;
		}

		return false;
	}

	/**
	 * Get post positive stat.
	 *
	 * @param int $post_id Post ID to get Positive votes stat.
	 *
	 * @return int
	 */
	public static function get_positive_stat( $post_id ) {
		$table = DB_Table_Util::get_votes_table();

		$all_votes_count = $table->get_count(
			array(
				'post_id' => $post_id,
			)
		);

		if ( $all_votes_count ) {
			$positive_count = $table->get_count(
				array(
					'post_id'  => $post_id,
					'positive' => 1,
				)
			);

			if ( $positive_count ) {
				return ceil( ( $positive_count / $all_votes_count ) * 100 );
			}
		}

		return 0;
	}

	/**
	 * Get post positive stat.
	 *
	 * @param int $post_id Post ID to get Positive votes stat.
	 *
	 * @return int
	 */
	public static function get_negative_stat( $post_id ) {
		$table = DB_Table_Util::get_votes_table();

		$all_votes_count = $table->get_count(
			array(
				'post_id' => $post_id,
			)
		);

		if ( $all_votes_count ) {
			$positive_count = $table->get_count(
				array(
					'post_id'  => $post_id,
					'negative' => 1,
				)
			);

			if ( $positive_count ) {
				return floor( ( $positive_count / $all_votes_count ) * 100 );
			}
		}

		return 0;
	}

	/**
	 * Get filtered votes.
	 *
	 * @param array $filter Array to filter data.
	 * @param int   $limit Count of retrieved data.
	 *
	 * @return array
	 */
	public static function find( $filter, $limit = 0 ) {
		$table = DB_Table_Util::get_votes_table();
		return $table->filter( $filter, $limit );
	}
}
