<?php
/**
 * Display metabox with post voting results.
 *
 * @package WP_Voting_System
 */

if ( empty( $args ) ) {
	return;
}

if ( ! empty( $args['positive'] ) ) {
	$wpvs_positive_text = $args['positive'] . '%';
} else {
	$wpvs_positive_text = '0%';
}

if ( ! empty( $args['negative'] ) ) {
	$wpvs_negative_text = $args['negative'] . '%';
} else {
	$wpvs_negative_text = '0%';
}
?>
<div class="wpvs-btns-wrapper wpvs-results">
	<p>
		<strong>
			<?php esc_html_e( 'Positive:', 'wp-voting-system' ); ?>
		</strong>
		<span>
			<?php echo esc_html( $wpvs_positive_text ); ?>
		</span>
	</p>
	<p>
		<strong>
			<?php esc_html_e( 'Negative:', 'wp-voting-system' ); ?>
		</strong>
		<span>
			<?php echo esc_html( $wpvs_negative_text ); ?>
		</span>
	</p>
</div>
