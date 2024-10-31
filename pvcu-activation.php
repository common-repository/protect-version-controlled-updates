<?php

/*
 * This function uses the output of pvcu_find_version_control()
 * to set options in the options table upon plugin activation.
 *
 * @uses pvcu_find_version_control To find what components have VC'ed folders
 *
 * @param void
 * @return void
 */

function pvcu_activation() {
	// Find out if there's a .git or .svn folder somewhere
	$vc_files_found = pvcu_find_version_control();
	add_option( 'pvcu_return', $vc_files_found );

	// Create an array of option values
	$pvcu_options_array = array();

	if( $vc_files_found[ 'plugins' ] === true ) {
		$pvcu_options_array[ 'pvcu_plugins_action' ] = 'warn';
	} else {
		$pvcu_options_array[ 'pvcu_plugins_action' ] = 'none';
	}

	if( $vc_files_found[ 'themes' ] === true ) {
		$pvcu_options_array[ 'pvcu_themes_action' ] = 'warn';
	} else {
		$pvcu_options_array[ 'pvcu_themes_action' ] = 'none';
	}

	// Uncomment when able to stop core updates.

	// if( $vc_files_found[ 'core' ] === true ) {
	// 	$pvcu_options_array[ 'pvcu_core_action' ] = 'warn';
	// } else {
	// 	$pvcu_options_array[ 'pvcu_core_action' ] = 'none';
	// }

	$pvcu_options_array[ 'pvcu_modal_title' ] = 'Update Warning';
	$pvcu_options_array[ 'pvcu_modal_content' ] = 'Are you sure you want to update this item? Please check with your web development company before doing so.';

	add_option( 'pvcu_settings', $pvcu_options_array, '', FALSE );
}

register_activation_hook( __DIR__ . '/pvcu-main.php', 'pvcu_activation' );