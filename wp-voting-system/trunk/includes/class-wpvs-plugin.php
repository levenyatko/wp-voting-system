<?php
	/**
	 * Main plugin class
	 *
	 * @package WP_Voting_System
	 */

	namespace WP_Voting_System;

	use WP_Voting_System\Admin\Metaboxes\Post_Voting_Report_Metabox;
	use WP_Voting_System\Admin\Pages\Settings_Page;
	use WP_Voting_System\AJAX\Actions\Post_Vote_Action;
	use WP_Voting_System\AJAX\AJAX_Actions_Registrar;
	use WP_Voting_System\Front\Voting_Block;
	use WP_Voting_System\Hooks\Actions\Vote_Action;
	use WP_Voting_System\Utils\DB_Table_Util;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class WPVS_Plugin
	 */
final class WPVS_Plugin {

	/**
	 * Current plugin version.
	 *
	 * @var string $version
	 */
	public static $version = '1.0.0';

	/**
	 * An instance of the `Hooks_Manager` class.
	 *
	 * @var Hooks_Manager $hooks_manager
	 */
	public $hooks_manager;

	/**
	 * An instance of the `Settings_Page` class.
	 *
	 * @var Settings_Page $settings_page
	 */
	public $settings_page;

	/**
	 * An instance of the `AJAX_Actions_Registrar` class.
	 *
	 * @var AJAX_Actions_Registrar $ajax_actions
	 */
	public $ajax_actions;

	/**
	 * Plugin base name
	 *
	 * @var string $plugin_basename
	 */
	public $plugin_basename;

	/**
	 * Construct the plugin.
	 *
	 * @param string $plugin_base_file Plugin base file path.
	 */
	public function __construct( $plugin_base_file ) {

		$this->plugin_basename = plugin_basename( $plugin_base_file );

		add_action( 'plugins_loaded', array( $this, 'init' ) );

		add_filter(
			'plugin_action_links_' . $this->plugin_basename,
			array(
				$this,
				'plugin_settings_link',
			)
		);

		register_activation_hook(
			$plugin_base_file,
			function () {
				$this->activate(
					new WPVS_Activator()
				);
			}
		);

	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function init() {
		$this->init_dependencies();
	}

	/**
	 * Create instances of plugin classes.
	 *
	 * @return void
	 */
	private function init_dependencies() {
		$this->hooks_manager = new Hooks_Manager();

		$voting_block = new Voting_Block( self::$version );
		$this->hooks_manager->register( $voting_block );

		$this->ajax_actions = new AJAX_Actions_Registrar();
		$this->ajax_actions->add_action( new Post_Vote_Action() );
		$this->ajax_actions->register();

		if ( is_admin() ) {
			$this->settings_page = new Settings_Page();
			$this->hooks_manager->register( $this->settings_page );

			$voting_metabox = new Post_Voting_Report_Metabox();
			$this->hooks_manager->register( $voting_metabox );
		}
	}

	/**
	 * Run on plugin activation.
	 *
	 * @param WPVS_Activator $activator Activator class.
	 *
	 * @return void
	 */
	public function activate( WPVS_Activator $activator ) {
		$activator->add_table( DB_Table_Util::get_votes_table() );
		$activator->install();
	}

	/**
	 * Adds settings link to the plugins page.
	 *
	 * @param array $links Plugin links array.
	 *
	 * @return array mixed
	 */
	public function plugin_settings_link( $links ) {
		$settings_url  = $this->settings_page->get_url();
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_attr( $settings_url ),
			esc_html__( 'Settings', 'wp-voting-system' )
		);

		array_unshift( $links, $settings_link );

		return $links;
	}
}
