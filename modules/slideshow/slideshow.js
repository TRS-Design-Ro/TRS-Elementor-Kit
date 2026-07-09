/**
 * TRS Slideshow
 *
 * Handles slide transitions (fade or horizontal slide), the segmented
 * "line" slide changer, optional prev/next arrows, autoplay, keyboard
 * navigation, and touch swipe. Autoplay is disabled inside the Elementor
 * editor so it doesn't fight with panel interactions.
 */
( function ( $ ) {
	'use strict';

	var initSlideshow = function ( $scope ) {

		var $slideshow = $scope.find( '.trs-slideshow' );
		if ( ! $slideshow.length ) { return; }

		var $track  = $slideshow.find( '.trs-ss-track' );
		var $slides = $slideshow.find( '.trs-ss-slide' );
		var total   = $slides.length;

		if ( total < 1 ) { return; }

		// Avoid double-binding if Elementor re-fires element_ready.
		if ( $slideshow.data( 'trs-ss-bound' ) ) { return; }
		$slideshow.data( 'trs-ss-bound', true );

		var effect      = $slideshow.data( 'effect' ) === 'slide' ? 'slide' : 'fade';
		var current     = Math.max( 0, $slides.filter( '.trs-ss-slide--active' ).first().data( 'index' ) || 0 );
		var isAnimating = false;

		var $nav     = $slideshow.find( '.trs-ss-nav' );
		var $lines   = $nav.find( '.trs-ss-line' );
		var $prevBtn = $slideshow.find( '.trs-ss-arrow--prev' );
		var $nextBtn = $slideshow.find( '.trs-ss-arrow--next' );

		// ------------------------------------------------------------------
		// Autoplay settings (read from data attributes set by PHP)
		// ------------------------------------------------------------------

		var autoplay     = $slideshow.data( 'autoplay' ) === true;
		var autoInterval = parseFloat( $slideshow.data( 'autoplay-interval' ) ) || 6000;
		var pauseHover   = $slideshow.data( 'autoplay-pause-hover' ) === true;
		var autoTimer    = null;
		var hoverPaused  = false;

		var inEditor = ( typeof elementorFrontend !== 'undefined' ) && elementorFrontend.isEditMode();

		// ------------------------------------------------------------------
		// Core: activate a given slide index
		// ------------------------------------------------------------------

		function render() {
			$slides.each( function ( i ) {
				var $slide = $( this );
				var active = i === current;
				$slide
					.toggleClass( 'trs-ss-slide--active', active )
					.attr( 'aria-hidden', active ? 'false' : 'true' );
			} );

			$lines.each( function ( i ) {
				var $line = $( this );
				$line
					.toggleClass( 'trs-ss-line--active', i === current )
					.attr( 'aria-selected', i === current ? 'true' : 'false' );
			} );

			if ( 'slide' === effect ) {
				$track.css( 'transform', 'translateX(-' + ( current * 100 ) + '%)' );
			}
		}

		function goTo( index ) {
			var next = ( ( index % total ) + total ) % total;
			if ( isAnimating || next === current ) { return; }
			isAnimating = true;
			current = next;
			render();
			setTimeout( function () { isAnimating = false; }, parseFloat( getComputedStyle( $slideshow[ 0 ] ).getPropertyValue( '--trs-ss-speed' ) ) || 700 );
		}

		function navigate( direction ) {
			goTo( current + direction );
		}

		// ------------------------------------------------------------------
		// Auto-play
		// ------------------------------------------------------------------

		function startAutoplay() {
			if ( ! autoplay || inEditor || total < 2 ) { return; }
			clearInterval( autoTimer );
			autoTimer = setInterval( function () {
				if ( ! hoverPaused ) { navigate( 1 ); }
			}, autoInterval );
		}

		function stopAutoplay() {
			clearInterval( autoTimer );
			autoTimer = null;
		}

		function resetAutoplay() {
			if ( autoplay && ! inEditor ) {
				stopAutoplay();
				startAutoplay();
			}
		}

		// ------------------------------------------------------------------
		// Boot
		// ------------------------------------------------------------------

		render();

		requestAnimationFrame( function () {
			requestAnimationFrame( function () {
				$slideshow.addClass( 'trs-ss-initialized' );
				startAutoplay();
			} );
		} );

		// ------------------------------------------------------------------
		// Events
		// ------------------------------------------------------------------

		$prevBtn.on( 'click', function () { navigate( -1 ); resetAutoplay(); } );
		$nextBtn.on( 'click', function () { navigate( 1 );  resetAutoplay(); } );

		$nav.on( 'click', '.trs-ss-line', function () {
			goTo( parseInt( $( this ).data( 'idx' ), 10 ) );
			resetAutoplay();
		} );

		$slideshow.attr( 'tabindex', '0' ).on( 'keydown', function ( e ) {
			if ( e.key === 'ArrowLeft'  ) { navigate( -1 ); resetAutoplay(); e.preventDefault(); }
			if ( e.key === 'ArrowRight' ) { navigate( 1 );  resetAutoplay(); e.preventDefault(); }
		} );

		// Swipe (touch)
		var touchStartX = 0;
		var trackEl     = $track[ 0 ];

		trackEl.addEventListener( 'touchstart', function ( e ) {
			touchStartX = e.touches[ 0 ].clientX;
		}, { passive: true } );

		trackEl.addEventListener( 'touchend', function ( e ) {
			var delta = touchStartX - e.changedTouches[ 0 ].clientX;
			if ( Math.abs( delta ) > 50 ) {
				navigate( delta > 0 ? 1 : -1 );
				resetAutoplay();
			}
		}, { passive: true } );

		// Hover pause/resume
		if ( pauseHover ) {
			$slideshow.on( 'mouseenter focusin', function () { hoverPaused = true; } );
			$slideshow.on( 'mouseleave focusout', function () { hoverPaused = false; } );
		}
	};

	$( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-slideshow.default',
			initSlideshow
		);
	} );

} )( jQuery );
