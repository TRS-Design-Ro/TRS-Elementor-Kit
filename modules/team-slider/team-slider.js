/**
 * TRS Team Slider
 *
 * Desktop (≥ 768 px)
 *   Slot model relative to `current`:
 *     slot 0 – active    (left: 0,             width: activeW)
 *     slot 1 – preview-1 (left: activeW + gap,  width: previewW)
 *     slot 2 – preview-2 (left: …,              width: previewW)
 *     hiddenLeft  – slide immediately before current (ready for prev anim)
 *     hiddenRight – every other hidden slide
 *
 * Mobile (< 768 px)
 *   One slide visible at full viewport width.
 *   Hidden slides are parked just outside the viewport edges (opacity 1,
 *   clipped by overflow:hidden) so they glide in/out without fading.
 *   Dot indicators replace the arrow buttons.
 *
 * Auto-play
 *   Configured via data-autoplay / data-autoplay-interval /
 *   data-autoplay-pause-hover attributes output by the PHP widget.
 *   The timer is reset on every manual interaction (click, keyboard, swipe).
 *   Auto-play is disabled inside the Elementor editor to avoid interfering
 *   with panel interactions.
 */
( function ( $ ) {
	'use strict';

	var MOBILE_BP = 768; // px — must match the CSS @media breakpoint

	var initTeamSlider = function ( $scope ) {

		var $slider   = $scope.find( '.trs-team-slider' );
		if ( ! $slider.length ) { return; }

		var $viewport = $slider.find( '.trs-ts-viewport' );
		var $slides   = $slider.find( '.trs-ts-slide' );
		var $prevBtn  = $slider.find( '.trs-ts-arrow--prev' );
		var $nextBtn  = $slider.find( '.trs-ts-arrow--next' );
		var $dotsWrap = $slider.find( '.trs-ts-dots' );
		var total     = $slides.length;

		if ( total < 1 ) { return; }

		var current     = 0;
		var isAnimating = false;
		var ANIM_MS     = 700; // ≥ CSS --trs-ts-dur (0.65 s) + buffer

		// ------------------------------------------------------------------
		// Auto-play settings (read from data attributes set by PHP)
		// ------------------------------------------------------------------

		var autoplay      = $slider.data( 'autoplay' ) === true;
		var autoInterval  = ( parseFloat( $slider.data( 'autoplay-interval' ) ) || 5 ) * 1000;
		var pauseHover    = $slider.data( 'autoplay-pause-hover' ) === true;
		var autoTimer     = null;
		var hoverPaused   = false;

		// Never auto-play while the user is editing in Elementor
		var inEditor = ( typeof elementorFrontend !== 'undefined' ) && elementorFrontend.isEditMode();

		// ------------------------------------------------------------------
		// Helpers
		// ------------------------------------------------------------------

		var el = $slider[0];

		function isMobile() {
			return window.innerWidth < MOBILE_BP;
		}

		function getCSSVar( name ) {
			return parseFloat( getComputedStyle( el ).getPropertyValue( name ).trim() ) || 0;
		}

		/** Returns geometry constants for the current breakpoint. */
		function layout() {
			if ( isMobile() ) {
				var vw = $viewport.width() || 300;
				return { activeW: vw, previewW: vw, gap: 12, mobile: true };
			}
			return {
				activeW  : getCSSVar( '--trs-ts-active-w'  ) || 726,
				previewW : getCSSVar( '--trs-ts-preview-w' ) || 305,
				gap      : getCSSVar( '--trs-ts-gap'       ) || 24,
				mobile   : false,
			};
		}

		// ------------------------------------------------------------------
		// Dots
		// ------------------------------------------------------------------

		function buildDots() {
			$dotsWrap.empty();
			for ( var i = 0; i < total; i++ ) {
				$( '<button>' )
					.addClass( 'trs-ts-dot' )
					.attr( 'aria-label', 'Slide ' + ( i + 1 ) )
					.attr( 'data-idx', i )
					.appendTo( $dotsWrap );
			}
		}

		function updateDots() {
			$dotsWrap.find( '.trs-ts-dot' ).each( function ( i ) {
				$( this ).toggleClass( 'trs-ts-dot--active', i === current );
			} );
		}

		// ------------------------------------------------------------------
		// Core: set every slide's geometry + state class
		// ------------------------------------------------------------------

		function updateSlides() {
			var l       = layout();
			var prevIdx = ( current - 1 + total ) % total;

			// Visible slots
			var slot = [
				{ left: 0,                                        width: l.activeW  },
				{ left: l.activeW + l.gap,                        width: l.previewW },
				{ left: l.activeW + l.gap * 2 + l.previewW,      width: l.previewW },
			];

			// Off-screen anchor positions
			var hiddenLeft, hiddenRight, hiddenOpacity;

			if ( l.mobile ) {
				// Slides park just outside the viewport edges at full width.
				// opacity stays 1 so they glide in from the side (clipped by viewport).
				hiddenLeft    = { left: -( l.activeW + l.gap ), width: l.activeW };
				hiddenRight   = { left:   l.activeW + l.gap,   width: l.activeW };
				hiddenOpacity = 1;
			} else {
				// Desktop: hidden slides collapse to zero width.
				hiddenLeft    = { left: -( l.previewW + l.gap ),                  width: 0 };
				hiddenRight   = { left: l.activeW + l.gap * 3 + l.previewW * 2,  width: 0 };
				hiddenOpacity = 0;
			}

			$slides.each( function ( i ) {
				var $slide  = $( this );
				var offset  = ( ( i - current ) % total + total ) % total;
				var pos, visible, cls;

				if ( offset === 0 ) {
					pos = slot[0]; visible = true; cls = 'trs-ts-slide--active';

				} else if ( ! l.mobile && offset === 1 ) {
					pos = slot[1]; visible = true; cls = 'trs-ts-slide--preview';

				} else if ( ! l.mobile && offset === 2 && total > 2 ) {
					pos = slot[2]; visible = true; cls = 'trs-ts-slide--preview';

				} else if ( i === prevIdx ) {
					// One slide to the left — ready to enter on prev navigation
					pos = hiddenLeft; visible = false; cls = 'trs-ts-slide--hidden';

				} else {
					pos = hiddenRight; visible = false; cls = 'trs-ts-slide--hidden';
				}

				$slide
					.css( {
						left   : pos.left + 'px',
						width  : pos.width + 'px',
						opacity: visible ? 1 : hiddenOpacity,
					} )
					.attr( 'aria-hidden', visible ? 'false' : 'true' )
					.removeClass( 'trs-ts-slide--active trs-ts-slide--preview trs-ts-slide--hidden' )
					.addClass( cls );

				$slide.find( '.trs-ts-content' )
					.attr( 'aria-hidden', cls === 'trs-ts-slide--active' ? 'false' : 'true' );
			} );
		}

		// ------------------------------------------------------------------
		// Navigation
		// ------------------------------------------------------------------

		function goTo( index ) {
			if ( isAnimating || index === current ) { return; }
			isAnimating = true;
			current     = ( ( index % total ) + total ) % total;
			updateSlides();
			updateDots();
			setTimeout( function () { isAnimating = false; }, ANIM_MS );
		}

		function navigate( direction ) {
			goTo( current + direction );
		}

		// ------------------------------------------------------------------
		// Auto-play
		// ------------------------------------------------------------------

		function startAutoplay() {
			if ( ! autoplay || inEditor ) { return; }
			clearInterval( autoTimer );
			autoTimer = setInterval( function () {
				if ( ! hoverPaused ) { navigate( 1 ); }
			}, autoInterval );
		}

		function stopAutoplay() {
			clearInterval( autoTimer );
			autoTimer = null;
		}

		/** Restart the countdown after a manual interaction. */
		function resetAutoplay() {
			if ( autoplay && ! inEditor ) {
				stopAutoplay();
				startAutoplay();
			}
		}

		// ------------------------------------------------------------------
		// Boot
		// ------------------------------------------------------------------

		buildDots();
		updateDots();
		updateSlides();

		// Two rAF frames: let the browser paint positions before enabling
		// transitions, preventing a "slide-in" flash on first load.
		requestAnimationFrame( function () {
			requestAnimationFrame( function () {
				$slider.addClass( 'trs-ts-initialized' );
				startAutoplay();
			} );
		} );

		// ------------------------------------------------------------------
		// Event bindings
		// ------------------------------------------------------------------

		$prevBtn.on( 'click', function () { navigate( -1 ); resetAutoplay(); } );
		$nextBtn.on( 'click', function () { navigate( 1 );  resetAutoplay(); } );

		// Dot clicks → jump directly to that slide
		$dotsWrap.on( 'click', '.trs-ts-dot', function () {
			goTo( parseInt( $( this ).attr( 'data-idx' ), 10 ) );
			resetAutoplay();
		} );

		// Keyboard
		$slider.on( 'keydown', function ( e ) {
			if ( e.key === 'ArrowLeft'  ) { navigate( -1 ); resetAutoplay(); e.preventDefault(); }
			if ( e.key === 'ArrowRight' ) { navigate( 1 );  resetAutoplay(); e.preventDefault(); }
		} );

		// Swipe (mobile + touch screens)
		var touchStartX = 0;

		$viewport[0].addEventListener( 'touchstart', function ( e ) {
			touchStartX = e.touches[0].clientX;
		}, { passive: true } );

		$viewport[0].addEventListener( 'touchend', function ( e ) {
			var delta = touchStartX - e.changedTouches[0].clientX;
			if ( Math.abs( delta ) > 50 ) {
				navigate( delta > 0 ? 1 : -1 );
				resetAutoplay();
			}
		}, { passive: true } );

		// Hover pause/resume
		if ( pauseHover ) {
			$slider.on( 'mouseenter focusin', function () {
				hoverPaused = true;
			} );
			$slider.on( 'mouseleave focusout', function () {
				hoverPaused = false;
			} );
		}

		// Recalculate geometry on resize (breakpoint may cross, CSS vars may change)
		var resizeTimer;
		$( window ).on( 'resize.trs-ts-' + ( $slider.attr( 'id' ) || '' ), function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function () {
				// Re-position without transition flash
				$slider.removeClass( 'trs-ts-initialized' );
				updateSlides();
				requestAnimationFrame( function () {
					requestAnimationFrame( function () {
						$slider.addClass( 'trs-ts-initialized' );
					} );
				} );
			}, 150 );
		} );
	};

	$( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-team-slider.default',
			initTeamSlider
		);
	} );

} )( jQuery );
