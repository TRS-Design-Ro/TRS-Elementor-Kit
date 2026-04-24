( function( $ ) {
	const initProgressBars = function() {
		// Reserved for future front-end interactions.
	};

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/trs-progress-bars.default', initProgressBars );
	} );
} )( jQuery );
