<?php
	/**
	 * Plugin Activator.
	 *
	 * @package WP_Voting_System
	 */

	namespace WP_Voting_System;

	use WP_Voting_System\Interfaces\DB_Table_Interface;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class WPVS_Activator
	 */
class WPVS_Activator {

	/**
	 * Tables to create.
	 *
	 * @var DB_Table_Interface[] $table_objects
	 */
	private $table_objects;

	/**
	 * Class construct.
	 */
	public function __construct() {
		$this->table_objects = array();
	}

	/**
	 * Add new table to the list.
	 *
	 * @param DB_Table_Interface $table Action to add.
	 *
	 * @return void
	 */
	public function add_table( DB_Table_Interface $table ) {
		$this->table_objects[] = $table;
	}

	/**
	 * Run plugin install.
	 *
	 * @return void
	 */
	public function install() {
		$this->create_tables();
	}

	/**
	 * Create custom plugin tables.
	 *
	 * @return void
	 */
	public function create_tables() {
		if ( ! empty( $this->table_objects ) && is_array( $this->table_objects ) ) {
			foreach ( $this->table_objects as $table_object ) {
				$table_object->create();
			}
		}
	}
}
