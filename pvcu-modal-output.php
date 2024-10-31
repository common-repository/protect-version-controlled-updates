<?php

/*
 * Generates the modal popup.
 *
 * @uses get_option Gets the value of the plugin option
 * @uses pvcu_get_current_screen Gets the base for the current screen
 * @uses pvcu_get_current_screen_relevant_option Gets the key for the needed value for this screen
 *
 * @param void
 * @return string HTML for the popup.
 */

function pvcu_modal_output() {
	$full_settings = '';
	$current_screen = '';
	$current_screen_key = '';
	$current_screen_action = '';
	$modal_title = '';
	$modal_content = '';

	$full_settings = get_option( 'pvcu_settings' );
	$current_screen = pvcu_get_current_screen();
	$current_screen_option = pvcu_get_current_screen_relevant_option( $current_screen );
	$modal_title = $full_settings[ 'pvcu_modal_title' ];
	$modal_content = $full_settings[ 'pvcu_modal_content' ];

	ob_start();
	foreach( $current_screen_option as $key => $value ) {
		$option_value = $full_settings[ $value ];
		
		// Don't generate a modal if the option is set to 'none'
		if( $option_value == 'none' ) {
			continue;
		}
		
		?>
		<div id="pvcuModal-<?php echo $key; ?>" class="modal hide fade" tabindex="-1" >
			<div class="modal-header">
				<h3><?php echo $modal_title; ?></h3>
			</div>
			<div class="modal-body">
				<?php echo apply_filters( 'the_content', $modal_content ); ?>
			</div>
			<div class="modal-footer">
				<button id="dismiss" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<?php if( $option_value != 'block' ) { ?>
					<button id="update" class="btn btn-primary" data-confirm="true" aria-hidden="false" >Update</button>
				<?php } ?>
			</div>
		</div>
		<?php
	} // End foreach
	$output = ob_get_clean();
	apply_filters( 'pvcu_output', $output );

	return $output;
}

/*
 * Inject the modal HTML into the admin page.
 *
 * @uses pvcu_load_assets Determines if the modal should be
 *						  injected into this page.
 *
 * @param void
 * @return string Echoes the HTML
 */

function pvcu_modal_action() {
	/*
	 * We only want the modal injected on pages we've
	 * designated.
	 */

	if( ! pvcu_load_assets() ) {
		return;
	};

	echo pvcu_modal_output();
}

add_action( 'admin_head', 'pvcu_modal_action' );