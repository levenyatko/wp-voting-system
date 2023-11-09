<?php
	/**
	 * DB table classes contract.
	 *
	 * @package WP_Voting_System\Interfaces
	 */

	namespace WP_Voting_System\Interfaces;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Interface DB_Table_Interface
	 */
interface DB_Table_Interface {

	/**
	 * Get table name.
	 *
	 * @return string
	 */
	public function get_table_name();

	/**
	 * Create table.
	 *
	 * @return void
	 */
	public function create();
}
