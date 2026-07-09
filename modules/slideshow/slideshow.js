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
		var autoTimeout  = null;
		var remainingMs  = autoInterval;
		var cycleStartTs = 0;

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
		// Auto-play + per-line "loading" progress bar
		// ------------------------------------------------------------------

		function clearAutoTimeout() {
			if ( autoTimeout ) {
				clearTimeout( autoTimeout );
				autoTimeout = null;
			}
		}

		// Animates the current slide's nav line from 0% → 100% over `ms`,
		// synced with the autoplay timer. No-op when autoplay isn't running.
		function animateCurrentLine( ms ) {
			$lines.removeClass( 'trs-ss-line--animating' );

			if ( ! autoplay || inEditor || total < 2 ) { return; }

			var lineEl = $lines.get( current );
			if ( ! lineEl ) { return; }

			lineEl.style.setProperty( '--trs-ss-autoplay-duration', ms + 'ms' );
			// Force a reflow so the keyframe animation restarts from 0 even
			// when re-applied to the same element (e.g. single-slide loop).
			void lineEl.offsetWidth;
			lineEl.classList.add( 'trs-ss-line--animating' );
		}

		function startAutoplay() {
			if ( ! autoplay || inEditor || total < 2 ) { return; }
			clearAutoTimeout();
			remainingMs  = autoInterval;
			cycleStartTs = Date.now();
			animateCurrentLine( autoInterval );
			autoTimeout = setTimeout( function () {
				navigate( 1 );
				startAutoplay();
			}, autoInterval );
		}

		function stopAutoplay() {
			clearAutoTimeout();
			$lines.removeClass( 'trs-ss-line--animating' );
		}

		function resetAutoplay() {
			$slideshow.removeClass( 'trs-ss-autoplay-paused' );
			if ( autoplay && ! inEditor ) {
				startAutoplay();
			} else {
				stopAutoplay();
			}
		}

		// Hover/focus pause: freezes both the JS timer and the CSS animation
		// at their current position, and resumes both from there.
		function pauseAutoplay() {
			if ( ! autoTimeout ) { return; }
			clearAutoTimeout();
			remainingMs -= ( Date.now() - cycleStartTs );
			if ( remainingMs < 50 ) { remainingMs = 50; }
			$slideshow.addClass( 'trs-ss-autoplay-paused' );
		}

		function resumeAutoplay() {
			if ( ! autoplay || inEditor || total < 2 || autoTimeout ) { return; }
			$slideshow.removeClass( 'trs-ss-autoplay-paused' );
			cycleStartTs = Date.now();
			autoTimeout = setTimeout( function () {
				navigate( 1 );
				startAutoplay();
			}, remainingMs );
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
			$slideshow.on( 'mouseenter focusin', pauseAutoplay );
			$slideshow.on( 'mouseleave focusout', resumeAutoplay );
		}
	};

	$( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-slideshow.default',
			initSlideshow
		);
	} );

} )( jQuery );
