<?php
	/**
	 * Util to work with DB class.
	 *
	 * @package WP_Voting_System\Utils
	 */

	namespace WP_Voting_System\Utils;

	use WP_Voting_System\DB\Votes_Table;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class DB_Table_Util
	 */
class DB_Table_Util {

	/**
	 * Get Votes table obj.
	 *
	 * @return Votes_Table
	 */
	public static function get_votes_table() {
		global $wpdb;
		return new Votes_Table( $wpdb, '1.0' );
	}
}
