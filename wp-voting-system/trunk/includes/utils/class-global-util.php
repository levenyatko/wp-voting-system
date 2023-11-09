<?php
	/**
	 * Main plugin util class.
	 *
	 * @package WP_Voting_System\Utils
	 */

	namespace WP_Voting_System\Utils;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Global_Util
	 */
class Global_Util {

	/**
	 * Return the given value if it's set, otherwise return the default one.
	 *
	 * @param mixed $value Value to get.
	 * @param mixed $default_value Default value if $value wasn't set.
	 *
	 * @return mixed
	 */
	public static function default_value( &$value, $default_value ) {
		if ( isset( $value ) ) {
			return $value;
		}

		if ( isset( $default_value ) ) {
			return $default_value;
		}

		return null;
	}

	/**
	 * Get plugin setting.
	 *
	 * @param string $name Option name to get value.
	 * @param string $section Options section name to get value.
	 * @param mixed  $default_value Option default name.
	 *
	 * @return mixed
	 */
	public static function get_option( $name, $section, $default_value = '' ) {

		$options = get_option( $section );

		if ( isset( $options[ $name ] ) ) {
			return self::default_value( $options[ $name ], $default_value );
		}
		return $default_value;
	}
}
