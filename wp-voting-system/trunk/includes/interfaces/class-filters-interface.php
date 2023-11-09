<?php
/**
 * Filters Interface
 *
 * @package WP_Voting_System\Interfaces
 */

namespace WP_Voting_System\Interfaces;

defined( 'ABSPATH' ) || exit;

/**
 * Interface Filters_Interface
 */
interface Filters_Interface {

	/**
	 * Return the filters to register.
	 *
	 * @return array
	 */
	public function get_filters();
}
