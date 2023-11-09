<?php
	/**
	 * Abstract settings page class.
	 *
	 * @package WP_Voting_System\Abstracts
	 */

	namespace WP_Voting_System\Abstracts;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Abstract_Settings_Page
	 */
abstract class Abstract_Settings_Page {

	/**
	 * Current page name.
	 *
	 * @var string $page
	 */
	public $page = '';

	/**
	 * Setting fields.
	 *
	 * @return array
	 */
	abstract public function get_settings();

	/**
	 * Register settings sections and fields.
	 *
	 * @return void
	 */
	public function register_settings() {
		$settings = $this->get_settings();

		// register settings sections.
		foreach ( $settings as $section ) {

			if ( isset( $section['callback'] ) ) {
				$callback = $section['callback'];
			} else {
				$callback = null;
			}

			$section_id = $section['id'];

			add_settings_section(
				$section_id,
				$section['title'],
				$callback,
				$this->page
			);

			register_setting( $this->page, $section_id );

			// register section fields.
			foreach ( $section['fields'] as $option ) {
				$name     = isset( $option['name'] ) ? $option['name'] : 'No name';
				$type     = isset( $option['type'] ) ? $option['type'] : 'text';
				$label    = isset( $option['label'] ) ? $option['label'] : '';
				$callback = isset( $option['callback'] ) ? $option['callback'] : array( $this, 'callback_' . $type );

				$id = "{$section_id}[{$name}]";

				$args = array(
					'id'                => $name,
					'class'             => isset( $option['class'] ) ? $option['class'] : $name,
					'label_for'         => $id,
					'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
					'name'              => $label,
					'section'           => $section_id,
					'default'           => isset( $option['default'] ) ? $option['default'] : '',
					'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
					'type'              => $type,
				);
				add_settings_field( $id, $label, $callback, $this->page, $section_id, $args );
			}
		}
	}

	/**
	 * Get page url.
	 *
	 * @return string
	 */
	public function get_url() {
		return menu_page_url( $this->page, false );
	}
}
