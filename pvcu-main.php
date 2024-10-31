<?php
/*
Plugin Name: Protect Version Controlled Updates
Plugin URI: https://wordpress.org/plugins/protect-version-controlled-updates/
Description: This plugin is for version-controlled websites.  Depending on the settings, users attempting to update plugins will either get a popup asking for confirmation or will be totally prevented from updating.
Version: 1.1.0
Author: Shiny 9 Web Design
Author URI: http://www.shiny9web.com
Text Domain: protect-version-controlled-updates
Domain Path: /languages

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with This plugin. If not, see {License URI}.

*/

// General functions
include_once( __DIR__ . '/pvcu-general.php' );

// Activation functions
include_once( __DIR__ . '/pvcu-activation.php' );

// CSS, JS, and Bootstrap
include_once( __DIR__ . '/pvcu-scripts.php' );

// Option page goodness
include_once( __DIR__ . '/pvcu-options-page.php' );

// The modal
include_once( __DIR__ . '/pvcu-modal-output.php' );