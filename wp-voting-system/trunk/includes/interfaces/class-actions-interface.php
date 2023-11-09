<?php
/**
 * Actions Interface
 *
 * @package WP_Voting_System\Interfaces
 */

namespace WP_Voting_System\Interfaces;

defined( 'ABSPATH' ) || exit;

/**
 * Interface Actions_Interface
 */
interface Actions_Interface {

	/**
	 * Return the actions to register.
	 *
	 * @return array
	 */
	public function get_actions();
}
