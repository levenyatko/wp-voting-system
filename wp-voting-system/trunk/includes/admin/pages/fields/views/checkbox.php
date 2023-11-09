<?php
	/**
	 * Display checkbox field.
	 *
	 * @package WP_Voting_System
	 */

if ( ! isset( $field_id ) || ! isset( $field_name ) ) {
	return;
}

if ( ! isset( $value ) ) {
	$value = '';
}

?>
<fieldset>
	<label for="<?php echo esc_attr( $field_id ); ?>">
		<input type="checkbox"
				class="checkbox"
				id="<?php echo esc_attr( $field_id ); ?>"
				name="<?php echo esc_attr( $field_name ); ?>"
				value="yes"
			<?php checked( $value, 'yes' ); ?>
		/>
	</label>
	<?php if ( ! empty( $args['desc'] ) ) { ?>
		<p class="description"><?php echo esc_html( $args['desc'] ); ?></p>
	<?php } ?>
</fieldset>
