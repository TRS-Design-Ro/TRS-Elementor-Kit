( function( $ ) {

	'use strict';

	/**
	 * Initialises drag-to-scroll behaviour on a single carousel instance.
	 *
	 * @param {jQuery} $scope - The Elementor widget wrapper element.
	 */
	const initServicesCarousel = function( $scope ) {
		const $track = $scope.find( '.trs-sc-track' );
		if ( ! $track.length ) return;

		const track = $track[ 0 ];

		// ── Mouse drag ──────────────────────────────────────────────────────
		let isDown    = false;
		let startX    = 0;
		let scrollLeft = 0;

		$track.on( 'mousedown', function( e ) {
			isDown = true;
			$track.addClass( 'is-dragging' );
			startX     = e.pageX - track.offsetLeft;
			scrollLeft = track.scrollLeft;
		} );

		$track.on( 'mouseleave mouseup', function() {
			if ( ! isDown ) return;
			isDown = false;
			$track.removeClass( 'is-dragging' );
		} );

		$track.on( 'mousemove', function( e ) {
			if ( ! isDown ) return;
			e.preventDefault();
			const x    = e.pageX - track.offsetLeft;
			const walk = ( x - startX ) * 1.5;
			track.scrollLeft = scrollLeft - walk;
		} );

		// Prevent click-through after a drag
		$track.on( 'click', '.trs-sc-btn', function( e ) {
			if ( $track.hasClass( 'is-dragging' ) ) {
				e.preventDefault();
			}
		} );

		// ── Touch swipe ─────────────────────────────────────────────────────
		let touchStartX    = 0;
		let touchScrollLeft = 0;

		track.addEventListener( 'touchstart', function( e ) {
			touchStartX     = e.touches[ 0 ].pageX;
			touchScrollLeft = track.scrollLeft;
		}, { passive: true } );

		track.addEventListener( 'touchmove', function( e ) {
			const diff   = touchStartX - e.touches[ 0 ].pageX;
			track.scrollLeft = touchScrollLeft + diff;
		}, { passive: true } );
	};

	// ── Elementor lifecycle ──────────────────────────────────────────────────

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-services-carousel.default',
			initServicesCarousel
		);
	} );

} )( jQuery );
