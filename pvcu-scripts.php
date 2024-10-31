<?php

// Enqueue bootstrap, JS, and CSS, only on the plugin page

function pvcu_add_scripts() {

	if( ! pvcu_load_assets() ) {
		return;
	}

	wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'assets/bootstrap/js/bootstrap.min.js', '', '', true );
	wp_enqueue_script( 'pvcu-js', plugin_dir_url( __FILE__ ) . 'assets/js/pvcu.js', array( 'jquery', 'updates' ), '', true );
	wp_enqueue_style( 'pvcu-css', plugin_dir_url( __FILE__ ) . 'assets/css/pvcu.css' );
}

add_action( 'admin_enqueue_scripts', 'pvcu_add_scripts' );