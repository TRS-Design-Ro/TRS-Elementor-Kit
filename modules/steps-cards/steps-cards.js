( function( $ ) {
	const initStepsCards = function() {
		// Reserved for future enhancements.
	};

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/trs-steps-cards.default', initStepsCards );
	} );
} )( jQuery );
