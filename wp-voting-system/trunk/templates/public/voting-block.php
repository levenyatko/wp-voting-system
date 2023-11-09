<?php
	/**
	 * Display voting block front-end.
	 *
	 * @package WP_Voting_System
	 */

if ( empty( $args ) ) {
	return;
}
?>
	<div class="wpvs__container">
		<div class="wpvs__row">
			<?php if ( ! empty( $args['text'] ) ) { ?>
				<div class="wpvs__col">
					<span class="wpvs__text">
						<?php echo esc_html( apply_filters( 'wpvs_voting_text', $args['text'], $args ) ); ?>
					</span>
				</div>
			<?php } ?>
			<div class="wpvs__col">
				<?php if ( empty( $args['voted'] ) ) { ?>
					<div class="wpvs-btns-wrapper">
						<button class="wpvs__voting-btn wpvs__voting-btn--positive">
							<svg width="25px" height="25px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
								<path d="M128,24A104,104,0,1,0,232,128,104.12041,104.12041,0,0,0,128,24Zm36,72a12,12,0,1,1-12,12A12.0006,12.0006,0,0,1,164,96ZM92,96a12,12,0,1,1-12,12A12.0006,12.0006,0,0,1,92,96Zm84.50488,60.00293a56.01609,56.01609,0,0,1-97.00976.00049,8.00016,8.00016,0,1,1,13.85058-8.01074,40.01628,40.01628,0,0,0,69.30957-.00049,7.99974,7.99974,0,1,1,13.84961,8.01074Z"/>
							</svg>
							<span class="wpvs__text">
								<?php esc_html_e( 'Yes', 'wp-voting-system' ); ?>
							</span>
						</button>
						<button class="wpvs__voting-btn wpvs__voting-btn--negative">
							<svg width="25px" height="25px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
								<path d="M128,24A104,104,0,1,0,232,128,104.12041,104.12041,0,0,0,128,24ZM92,96a12,12,0,1,1-12,12A12.0006,12.0006,0,0,1,92,96Zm76,72H88a8,8,0,0,1,0-16h80a8,8,0,0,1,0,16Zm-4-48a12,12,0,1,1,12-12A12.0006,12.0006,0,0,1,164,120Z"/>
							</svg>
							<span class="wpvs__text">
								<?php esc_html_e( 'No', 'wp-voting-system' ); ?>
							</span>
						</button>
					</div>
					<?php
				} else {
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

					$wpvs_positive_item_classes = 'wpvs__voting-btn wpvs__voting-btn--positive';
					$wpvs_negative_item_classes = 'wpvs__voting-btn wpvs__voting-btn--negative';

					if ( ! empty( $args['voted_positive'] ) ) {
						$wpvs_positive_item_classes .= ' wpvs__voting-btn--voted';
					} else {
						$wpvs_negative_item_classes .= ' wpvs__voting-btn--voted';
					}
					?>
					<div class="wpvs-btns-wrapper wpvs-results">
						<span class="<?php echo esc_attr( $wpvs_positive_item_classes ); ?>">
							<svg width="25px" height="25px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
								<path d="M128,24A104,104,0,1,0,232,128,104.12041,104.12041,0,0,0,128,24Zm36,72a12,12,0,1,1-12,12A12.0006,12.0006,0,0,1,164,96ZM92,96a12,12,0,1,1-12,12A12.0006,12.0006,0,0,1,92,96Zm84.50488,60.00293a56.01609,56.01609,0,0,1-97.00976.00049,8.00016,8.00016,0,1,1,13.85058-8.01074,40.01628,40.01628,0,0,0,69.30957-.00049,7.99974,7.99974,0,1,1,13.84961,8.01074Z"/>
							</svg>
							<span class="wpvs__text">
							<?php echo esc_html( $wpvs_positive_text ); ?>
							</span>
						</span>
						<span class="<?php echo esc_attr( $wpvs_negative_item_classes ); ?>">
							<svg width="25px" height="25px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
								<path d="M128,24A104,104,0,1,0,232,128,104.12041,104.12041,0,0,0,128,24ZM92,96a12,12,0,1,1-12,12A12.0006,12.0006,0,0,1,92,96Zm76,72H88a8,8,0,0,1,0-16h80a8,8,0,0,1,0,16Zm-4-48a12,12,0,1,1,12-12A12.0006,12.0006,0,0,1,164,120Z"/>
							</svg>
							<span class="wpvs__text">
							<?php echo esc_html( $wpvs_negative_text ); ?>
							</span>
						</span>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
