<?php
	/**
	 * Template to show setitngs page.
	 *
	 * @package WP_Voting_System
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	global $wp_settings_sections;
?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<?php settings_errors(); ?>
	<?php
	if ( ! empty( $wp_settings_sections ) ) {
		foreach ( $wp_settings_sections as $wpvs_section_id => $wpvs_section ) {
			if ( false === strpos( $wpvs_section_id, 'wpvs' ) ) {
				continue;
			}
			?>
				<form method="POST" action="options.php">
				<?php
					settings_fields( $wpvs_section_id );
					do_settings_sections( $wpvs_section_id );
				?>
				<?php submit_button(); ?>
				</form>
			<?php
		}
	}
	?>
</div>
