<?php
	/**
	 * Class to get user data
	 *
	 * @package WP_Voting_System\Utils
	 */

	namespace WP_Voting_System\Utils;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Userdata_Util
	 */
class Userdata_Util {

	/**
	 * Get user IP hash.
	 *
	 * @return string
	 */
	public static function get_hashed_ip() {
		$ip = '';

		foreach ( array( 'HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key ) {
			if ( array_key_exists( $key, $_SERVER ) === true ) {
				foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) {
					$ip = trim( $ip );
					if ( filter_var( $ip, FILTER_VALIDATE_IP ) !== false ) {
						$ip = esc_attr( $ip );
					}
				}
			}
		}

		return wp_hash( $ip );
	}
}
