<?php
	/**
	 * Settings page class.
	 *
	 * @package WP_Voting_System\Admin\Pages
	 */

	namespace WP_Voting_System\Admin\Pages;

	use WP_Voting_System\Abstracts\Abstract_Settings_Page;
	use WP_Voting_System\Admin\Pages\Fields\Checkbox_Field;
	use WP_Voting_System\Admin\Pages\Fields\Text_Field;
	use WP_Voting_System\Interfaces\Actions_Interface;
	use WP_Voting_System\Interfaces\Admin_Page_Interface;
	use WP_Voting_System\Utils\Template_Util;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Settings_Page
	 */
class Settings_Page extends Abstract_Settings_Page implements Actions_Interface, Admin_Page_Interface {

	use Checkbox_Field;
		use Text_Field;

	/**
	 * Current page name.
	 *
	 * @var string $page
	 */
	public $page = 'wpvs-settings';

	/**
	 * Return the actions to register.
	 *
	 * @return array
	 */
	public function get_actions() {
		return array(
			'admin_menu' => array( 'add_page' ),
			'admin_init' => array( 'register_settings' ),
		);
	}

	/**
	 * Add admin menu page.
	 *
	 * @return void
	 */
	public function add_page() {
		add_menu_page(
			__( 'Settings', 'wp-voting-system' ),
			__( 'WP Voting System', 'wp-voting-system' ),
			'manage_options',
			$this->page,
			array( $this, 'display' ),
			'dashicons-heart'
		);
	}

	/**
	 * Display admin settings.
	 *
	 * @return void
	 */
	public function display() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Access Denied', 'wp-voting-system' ) );
		}

		Template_Util::include_template( 'settings', 'admin' );
	}

	/**
	 * Setting fields.
	 *
	 * @return array
	 */
	public function get_settings() {
		return array(
			array(
				'id'     => 'wpvs_voting_block',
				'title'  => __( 'Voting block settings', 'wp-voting-system' ),
				'fields' => array(
					array(
						'name'    => 'text',
						'label'   => __( 'Voting text', 'wp-voting-system' ),
						'desc'    => __( 'Text before voting buttons.', 'wp-voting-system' ),
						'type'    => 'text',
						'default' => __( 'Was this article helpful?', 'wp-voting-system' ),
					),
					array(
						'name'    => 'thank_you_text',
						'label'   => __( 'Thank you text', 'wp-voting-system' ),
						'desc'    => __( 'Text to display after successful.', 'wp-voting-system' ),
						'type'    => 'text',
						'default' => __( 'Thank you for your feedback.', 'wp-voting-system' ),
					),
				),
			),
			array(
				'id'     => 'wpvs_general',
				'title'  => __( 'General settings', 'wp-voting-system' ),
				'fields' => array(
					array(
						'name'    => 'clear_all_settings',
						'label'   => __( 'Clear all', 'wp-voting-system' ),
						'desc'    => __( 'Clear all data when uninstalling plugin', 'wp-voting-system' ),
						'type'    => 'checkbox',
						'default' => 'no',
					),
				),
			),
		);
	}
}
