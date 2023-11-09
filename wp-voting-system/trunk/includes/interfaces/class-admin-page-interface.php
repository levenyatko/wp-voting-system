<?php
/**
 * Admin page Interface
 *
 * @package WP_Voting_System\Interfaces
 */

namespace WP_Voting_System\Interfaces;

defined( 'ABSPATH' ) || exit;

/**
 * Interface Admin_Page_Interface
 */
interface Admin_Page_Interface {

	/**
	 * Add page to panel.
	 *
	 * @return void
	 */
	public function add_page();

	/**
	 * Display admin settings.
	 *
	 * @return void
	 */
	public function display();
}
