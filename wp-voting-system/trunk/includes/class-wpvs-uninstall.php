<?php
/**
 * Plugin uninstall class.
 *
 * @package WP_Voting_System
 */

namespace WP_Voting_System;

defined( 'ABSPATH' ) || exit;

/**
 * Class WPVS_Uninstall
 */
class WPVS_Uninstall {

	/**
	 * Tables to delete.
	 *
	 * @var string[] $table_names
	 */
	private $table_names;

	/**
	 * Options to delete.
	 *
	 * @var string[] $options
	 */
	private $options;

	/**
	 * Class construct.
	 */
	public function __construct() {
		$this->table_names = array(
			'wpvs_votes'
		);

		$this->options = array(
			'wpvs_voting_block',
			'wpvs_general',
		);
	}

	/**
	 * Add new table to the list.
	 *
	 * @param string $table Action to add.
	 *
	 * @return void
	 */
	public function add_table( $table ) {
		$this->table_names[] = $table;
	}

	/**
	 * Run plugin uninstall.
	 *
	 * @return void
	 */
	public function uninstall() {
		$settings = get_option( 'wpvs_general' );
		if ( ! empty( $settings[ 'clear_all_settings' ] ) && 'no' !== $settings[ 'clear_all_settings' ] ) {
			$this->remove_settings();
			$this->drop_tables();
		}
	}

	/**
	 * Remove custom settings.
	 *
	 * @return void
	 */
	private function remove_settings() {
		if ( ! empty( $this->options ) ) {
			foreach ( $this->options as $name ) {
				delete_option( $name );
			}
		}
	}

	/**
	 * Remove custom plugin tables.
	 *
	 * @return void
	 */
	private function drop_tables() {
		if ( ! empty( $this->table_names ) ) {
			foreach ( $this->table_names as $name ) {
				$table_name = $GLOBALS['wpdb']->base_prefix . $name;
				$query = 'DROP TABLE IF EXISTS %i';
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare( $query, $table_name ) );
			}
		}
	}
}