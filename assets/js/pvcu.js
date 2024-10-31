(function($) {
	// To disable the inline Shiny Plugin update link.
	$( 'a.update-link' ).addClass( 'update-link-disabled' ).removeClass( 'update-link' );
	
	// Intercept the update link on the plugins page (plugins.php)
	$( 'a.update-link-disabled' ).click( function( e ) {
		e.preventDefault();
		var updateLink = $(this).attr( 'href' );
		$( '#pvcuModal-plugins' ).modal();
		$( '#pvcuModal-plugins #update' ).click( function ( e2 ) {
			window.location=updateLink;
			return false;
		});
	});

	// Intercept the bulk update form on the plugins page (plugins.php)
	// If #pvcuModal-plugins hasn't been injected, that means protection is not enabled, so do nothing.
	if( $( '#pvcuModal-plugins' ).length ) {
		console.log( 'running' );
		$( 'form#bulk-action-form' ).submit( function( e, submit ) {
			var bulkActionOption = $( this ).find( 'select' ).val();
			if( bulkActionOption == 'update-selected' ) {
				if( ! submit ) {
					e.preventDefault();
					$( '#pvcuModal-plugins' ).modal();
				}
				
			}
		});

		$( '#pvcuModal-plugins #update' ).click( function() {
			$( 'form#bulk-action-form' ).trigger( 'submit', [true] );
		});
	}

	// Intercept the update link on the Theme Details page (themes.php)
	// TBD

	// Intercept the core update submit button on update-core.php.
	// Uncomment when able to stop core updates.
	// If #pvcuModal-core hasn't been injected, that means protection is not enabled, so do nothing.
	// if( $( '#pvcuModal-core' ).length ) {
	// 	$( 'form[name="upgrade"]' ).submit( function( e, submit ) {
	// 		if( ! submit ) {
	// 			e.preventDefault();
	// 			$( '#pvcuModal-core' ).modal();
	// 		}
	// 	});

	// 	$( '#pvcuModal-core #update' ).click( function() {
	// 		$( 'form[name="upgrade"]' ).trigger( 'submit', [true] );
	// 	});
	// }

	// Intercept the plugins update submit button on update-core.php
	// If #pvcuModal-plugins hasn't been injected, that means protection is not enabled, so do nothing.
	if( $( '#pvcuModal-plugins' ).length ) {
		$( 'form[name="upgrade-plugins"]' ).submit( function( e, submit ) {
			if( ! submit ) {
				e.preventDefault();
				$( '#pvcuModal-plugins' ).modal();
			}
		});

		$( '#pvcuModal-plugins #update' ).click( function() {
			$( 'form[name="upgrade-plugins"]' ).trigger( 'submit', [true] );
		});
	}

	// Intercept the themes update submit button on update-core.php
	// If #pvcuModal-themes hasn't been injected, that means protection is not enabled, so do nothing.
	if( $( '#pvcuModal-themes' ).length ) {
		$( 'form[name="upgrade-themes"]' ).submit( function( e, submit ) {
			if( ! submit ) {
				e.preventDefault();
				$( '#pvcuModal-themes' ).modal();
			}
		});

		$( '#pvcuModal-themes #update' ).click( function() {
			$( 'form[name="upgrade-themes"]' ).trigger( 'submit', [true] );
		});
	}
	
})( jQuery );