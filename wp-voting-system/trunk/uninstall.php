<?php
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @package WP_Voting_System
	 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit;
	}

require_once 'includes/class-wpvs-uninstall.php';

$uninstaller = new WP_Voting_System\WPVS_Uninstall();
$uninstaller->uninstall();
