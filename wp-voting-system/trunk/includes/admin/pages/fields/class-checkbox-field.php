<?php
	/**
	 * Checkbox settings field.
	 *
	 * @package WP_Voting_System\Admin\Pages\Fields
	 */

	namespace WP_Voting_System\Admin\Pages\Fields;

	use WP_Voting_System\Utils\Global_Util;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Trait Checkbox_Field
	 */
trait Checkbox_Field {

	/**
	 * Callback to show the field.
	 *
	 * @param array $args Field display args.
	 *
	 * @return void
	 */
	public function callback_checkbox( $args ) {
		$field_id   = sprintf( 'wpvs-%1$s-%2$s', $args['section'], $args['id'] );
		$field_name = sprintf( '%1$s[%2$s]', $args['section'], $args['id'] );
		$value      = Global_Util::get_option( $args['id'], $args['section'], $args['default'] );

		include 'views/checkbox.php';
	}
}
