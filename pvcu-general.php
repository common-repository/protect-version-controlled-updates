<?php

/*
 * This function will be part of the activation process. 
 * It looks through the file system at specific likely
 * points, looking for .git or .svn folders or files.  If present,
 * it returns true so that the protection is turned on 
 * automatically.
 *
 * @uses pvcu_is_version_controlled() Tests for the existence of
 *									  .git or .svn folders.
 *
 * @param void
 * @return array An array of the things to protect by default,
 *				 based off of existence of .git or .svn folders.
 *
 */

function pvcu_find_version_control() {
	$vc_controlled_paths = array();
	$plugins_dir_path = '';
	$themes_dir_path = '';
	$current_theme_path = '';
	$parent_theme_path = '';

	// Clear the built-in PHP file caching
	clearstatcache();

	// Set the defaults for the $vc_controlled_paths array
	$vc_controlled_paths[ 'plugins' ]	= false;
	$vc_controlled_paths[ 'themes' ]	= false;
	// Uncomment when able to stop core updates.
	// $vc_controlled_paths[ 'core' ]		= false;


	/*
	 * Check numerous server paths for .git or .svn folders.  
	 * There are a plethora of functions to get *URL's*, but
	 * fewer that get server paths.  As a result, some of 
	 * these are a little convoluted.
	 *
	 * For these paths, we're going to set the appropriate flag
	 * in $vc_controlled_paths - choices are 'plugins',
	 * 'themes', and 'core' - depending on the path.
	 */

	/*
	 * Sometimes the whole site is version-controlled, so look
	 * in the root. If true, set all three flags.
	 */

	// Needed for get_home_path() to work
	include_once( ABSPATH . 'wp-admin/includes/file.php' );

	if( pvcu_is_version_controlled( get_home_path() ) ) {
		$vc_controlled_paths[ 'plugins' ]	= true;
		$vc_controlled_paths[ 'themes' ]	= true;
		// Uncomment when able to stop core updates.
		// $vc_controlled_paths[ 'core' ]		= true;
	};

	/*
	 * Sometimes only the wp-content folder is VC'ed. If so, set
	 * 'plugins' and 'themes' flag.
	 * 
	 * @todo Using WP constants is frowned upon, find a better way.
	 */

	if( pvcu_is_version_controlled( WP_CONTENT_DIR ) ) {
		$vc_controlled_paths[ 'plugins' ]	= true;
		$vc_controlled_paths[ 'themes' ]	= true;
	};

	// Sometimes it's only the plugins or themes folders

	/*
	 * Find the parent directory of this plugin to determine
	 * the path to the plugins directory.  If this returns
	 * true, set 'plugins' flag.
	 */

	$plugins_dir_path = dirname( dirname( plugin_dir_path( __FILE__ ) ) );
	if( pvcu_is_version_controlled( $plugins_dir_path ) ) {
		$vc_controlled_paths[ 'plugins' ] = true;
	};

	/*
	 * If $plugins_dir_path isn't equal to WP_PLUGIN_DIR,
	 * that means that this plugin is in the mu-plugins
	 * directory.  The test above checked the mu-plugins
	 * folder already, so let's check WP_PLUGIN_DIR, and
	 * set the 'plugins' flag if true.
	 *
	 * @todo Using WP constants is frowned upon, find a better way.
	 */

	if( pvcu_is_version_controlled( WP_PLUGIN_DIR ) ) {
		$vc_controlled_paths[ 'plugins' ] = true;
	};

	/*
	 * Find the parent directory of the stylesheet path to
	 * determine the path to the themes directory.  If this
	 * returns true, set 'themes' flag.
	 */

	$themes_dir_path = dirname( get_stylesheet_directory() );

	if( pvcu_is_version_controlled( $themes_dir_path ) ) {
		$vc_controlled_paths[ 'themes' ] = true;
	};

	// And (very rarely) it's just the theme that's VC'ed.

	/*
	 * Find the stylesheet paths.  If the theme is VC'ed, there's 
	 * probably a parent and child theme.  I can't see why the 
	 * parent would be VC'ed but not the child, but let's check
	 * both just to be safe.  Set the 'themes' flag if either
	 * is true.
	 */

	$current_theme_path = get_stylesheet_directory();
	$parent_theme_path = get_template_directory();

	if( pvcu_is_version_controlled( $current_theme_path ) || pvcu_is_version_controlled( $parent_theme_path ) ) {
		$vc_controlled_paths[ 'themes' ] = true;
	}

	// Didn't I warn you that some of those were convoluted?

	return $vc_controlled_paths;

}

function pvcu_is_version_controlled( $path ) {

	/*
	 * Check the path, see if there's a VC-ed folder in that path, and set
	 * the appropriate flag if there is.
	 *
	 * @param string $path The path to check for a VC folder
	 * @return bool Whether there's a VC folder in $path.
	 */

	$vc_files_found = false;

	if( file_exists( $path . '/.git' ) || file_exists( $path . '/.svn' ) ) {
		$vc_files_found = true;
	}

	return $vc_files_found;
}

/*
 * This section tells us if the JS, modal, CSS, etc. should
 * be loaded on a page.
 *
 * @uses pvcu_get_current_screen() Gets the base of the current screen.
 * @uses pvcu_get_current_screen_relevant_option Gets the relevant option
 *												 based on current base.
 *
 *
 * @param void
 * @return bool Should this page have scripts and modals loaded on it?
 */

function pvcu_load_assets() {
	$full_options = '';
	$current_screen = '';
	$protected_screens = array();
	$current_screen_settings = '';
	$current_screen_option = array();
	$load_assets = '';

	// Get the current screen base
	$current_screen = pvcu_get_current_screen();
	
	$protected_screens = array( 'plugins', 'plugin-install', 'themes', 'update-core', );

	// Add or unset protected screens from the array if desired.
	$protected_screens = apply_filters( 'pvcu_protected_screens', $protected_screens );

	/*
	 * Check to see if the current screen is one of the ones which should be protected.
	 * If so, grab the option setting which corresponds to this type of page.  If it's
	 * set to 'none,' return false, but otherwise, return true.
	 */
	if( in_array( $current_screen, $protected_screens ) ) {
		$load_assets = false;
		$full_options = get_option( 'pvcu_settings' );
		$current_screen_option_name = pvcu_get_current_screen_relevant_option( $current_screen );

		foreach( $current_screen_option_name as $single_option ) {
			if( $single_option != 'none' ) {
				$load_assets = true;
			}
		}
		return $load_assets;
	} else {
		return false;  // This page isn't protected, don't load scripts or modal.
	}
}

/*
 * Gets the current screen base.
 *
 * @param void
 * @return string The base of the current screen
 */

function pvcu_get_current_screen() {
	$current_screen_object = new stdClass();
	$current_screen = '';

	// Get the base of the screen we're looking at.
	$current_screen_object = get_current_screen();
	$current_screen = $current_screen_object->base;

	return $current_screen;
}

/*
 * Given the base of a screen, this will return the name of the relevant
 * PVCU option.  Note that this doesn't return the *value* of the option,
 * just the key name to check in the option.
 *
 * @param string Current screen base
 * @return mixed Array (one $key=>$value pair) with the relevant setting
 *				 from the pvcu_settings option array, array (three pairs)
 *				 of all options if we're on the 'update-core' page, or 
 *				 null if the base doesn't have a corresponding option value.
 */

function pvcu_get_current_screen_relevant_option( $base ) {
	$screen_to_option_name = array();
	$option_name = '';

	/*
	 * For the 'update-core' page, we need to return an array
	 * of all three choices, since all three can be on the
	 * page.
	 */

	$screen_to_option_name = array(
		'plugins'			=>	array( 'plugins'	=>	'pvcu_plugins_action' ),
		'plugin-install'	=>	array( 'plugins'	=>	'pvcu_plugins_action' ),
		'themes'			=>	array( 'themes'		=>	'pvcu_themes_action' ),
		'update-core'		=>	array( 
			'plugins'		=>	'pvcu_plugins_action', 
			'themes'		=>	'pvcu_themes_action',
			// Uncomment when able to stop core updates.
			// 'core'			=>	'pvcu_core_action',
		),
	);

	/*
	 * Here's a chance to modify the array, in case new screens were added
	 * to the protected screens array using the pvcu_protected_screens
	 * filter.
	 */

	$screen_to_option_name = apply_filters( 'pvcu_screen_to_option_name', $screen_to_option_name );

	// Find the value of $base in this array
	if( isset( $screen_to_option_name[ $base ] ) ) {
		return $screen_to_option_name[ $base ];
	} else {
		return null;
	}
}