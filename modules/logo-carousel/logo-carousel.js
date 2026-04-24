( function ( $ ) {
	'use strict';

	/**
	 * Initialise a single Logo Carousel widget instance.
	 *
	 * Strategy
	 * --------
	 * 1. Measure the width of one complete set of original items (setW).
	 * 2. Clone enough sets so the total track width covers at least
	 *    (viewportWidth + setW) pixels — ensuring the viewport is always full
	 *    of content regardless of how many logos the user added.
	 * 3. Set --trs-lc-move on the carousel root to `setW + gap` (the exact
	 *    pixel distance that lands on the start of the first clone).
	 * 4. Add .trs-lc-track--animated, which triggers the CSS keyframe animation
	 *    that uses --trs-lc-move as its endpoint.
	 *
	 * @param {jQuery} $scope Elementor widget scope element.
	 */
	const initLogoCarousel = ( $scope ) => {
		const $carousel = $scope.find( '.trs-logo-carousel' );

		if ( ! $carousel.length || ! $carousel.hasClass( 'trs-lc--autoplay' ) ) {
			return;
		}

		const $viewport  = $carousel.find( '.trs-lc-viewport' );
		const $track     = $carousel.find( '.trs-lc-track' );
		const $origItems = $track.children( '.trs-lc-item' );

		if ( ! $origItems.length ) {
			return;
		}

		const track     = $track[ 0 ];
		const viewport  = $viewport[ 0 ];
		const viewportW = viewport.offsetWidth || 600;

		/**
		 * Returns the rendered width of the original items plus the gaps
		 * between them (gap is read from the track's computed column-gap).
		 */
		const getSetWidth = () => {
			const gap = parseFloat( getComputedStyle( track ).columnGap ) || 0;
			const itemsTotal = $track
				.children( '.trs-lc-item:not(.trs-lc-item--clone)' )
				.toArray()
				.reduce( ( sum, el ) => sum + el.offsetWidth, 0 );
			return itemsTotal + gap * ( $origItems.length - 1 );
		};

		/** Append one full copy of the original items to the track. */
		const cloneSet = () => {
			$origItems
				.clone()
				.addClass( 'trs-lc-item--clone' )
				.attr( 'aria-hidden', 'true' )
				.appendTo( $track );
		};

		const gap  = parseFloat( getComputedStyle( track ).columnGap ) || 0;
		const setW = getSetWidth();

		if ( setW === 0 ) {
			return;
		}

		/*
		 * moveBy = distance the track must scroll to complete one loop.
		 * Adding the gap between the last item of one set and the first item
		 * of the next set ensures the repeat point aligns exactly with the
		 * start of the next cloned set.
		 */
		const moveBy = setW + gap;

		/*
		 * We need: totalTrackWidth > viewportWidth + moveBy
		 * So that at the animation endpoint (−moveBy offset), the viewport
		 * is still fully covered. Number of extra clone sets needed:
		 *   setsToAdd = ceil( viewportWidth / moveBy ) + 1
		 */
		const setsToAdd = Math.ceil( viewportW / moveBy ) + 1;

		for ( let i = 0; i < setsToAdd; i++ ) {
			cloneSet();
		}

		// Tell the CSS keyframe how far to travel.
		$carousel[ 0 ].style.setProperty( '--trs-lc-move', moveBy + 'px' );

		// For RTL, the animation starts at −moveBy. Pre-position the track.
		if ( $carousel.hasClass( 'trs-lc--rtl' ) ) {
			track.style.transform = 'translateX(-' + moveBy + 'px)';
		}

		// Begin animating.
		$track.addClass( 'trs-lc-track--animated' );

		// Pause / resume on hover.
		if ( $carousel.hasClass( 'trs-lc--pause-on-hover' ) ) {
			$carousel
				.on( 'mouseenter.trs-lc', () => $track.addClass( 'trs-lc-track--paused' ) )
				.on( 'mouseleave.trs-lc', () => $track.removeClass( 'trs-lc-track--paused' ) );
		}

		/*
		 * Re-initialise on viewport resize (debounced).
		 * Item widths change at breakpoints due to cqi-based sizing, which
		 * changes setW and therefore moveBy.
		 */
		let resizeTimer;
		$( window ).on( 'resize.trs-lc-' + $scope.data( 'id' ), () => {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( () => reinit(), 300 );
		} );

		/** Tear down clones + animation then restart fresh. */
		const reinit = () => {
			$track.removeClass( 'trs-lc-track--animated trs-lc-track--paused' );
			track.style.transform = '';
			$track.children( '.trs-lc-item--clone' ).remove();
			$( window ).off( 'resize.trs-lc-' + $scope.data( 'id' ) );
			initLogoCarousel( $scope );
		};
	};

	$( window ).on( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-logo-carousel.default',
			initLogoCarousel
		);
	} );

} )( jQuery );
