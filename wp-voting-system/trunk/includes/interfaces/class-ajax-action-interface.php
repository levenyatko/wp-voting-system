<?php
	/**
	 * AJAX Action interface.
	 *
	 * @package WP_Voting_System\Interfaces
	 */

	namespace WP_Voting_System\Interfaces;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Interface AJAX_Action_Interface
	 */
interface AJAX_Action_Interface {

	/**
	 * Action callback function.
	 *
	 * @return mixed
	 */
	public function callback();
}
