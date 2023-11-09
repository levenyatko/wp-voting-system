<?php
	/**
	 * Metabox Interface.
	 *
	 * @package WP_Voting_System\Interfaces
	 */

	namespace WP_Voting_System\Interfaces;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Interface Metabox_Interface
	 */
interface Metabox_Interface {

	/**
	 * Metabox register function.
	 *
	 * @return void
	 */
	public function register();

	/**
	 * Metabox display function.
	 *
	 * @return void
	 */
	public function display();
}
