( function( $ ) {
	'use strict';

	const initTestimonials = ( $scope ) => {
		const $widget = $scope.find( '.trs-testimonial-cards' );
		if ( ! $widget.length || ! $widget.hasClass( 'trs-tc--animated' ) ) {
			return;
		}

		const pauseOnHover = $widget.hasClass( 'trs-tc--pause-hover' );
		const $rowViewports = $widget.find( '.trs-tc-row-viewport' );

		if ( ! $rowViewports.length ) {
			return;
		}

		const buildRow = ( $viewport ) => {
			const $track = $viewport.find( '.trs-tc-row-track' );
			const track = $track[0];
			const viewport = $viewport[0];
			if ( ! track || ! viewport ) {
				return;
			}

			$track.removeClass( 'trs-tc-track--animated trs-tc-track--paused' );
			track.style.transform = '';
			$track.children( '.trs-tc-item--clone' ).remove();
			$track.removeClass( 'trs-tc-track--rtl' );

			const $origItems = $track.children( '.trs-tc-item' );
			if ( ! $origItems.length ) {
				return;
			}

			const gap = parseFloat( getComputedStyle( track ).columnGap ) || 0;
			const setWidth = $origItems.toArray().reduce( ( total, item ) => total + item.offsetWidth, 0 ) + ( gap * Math.max( 0, $origItems.length - 1 ) );
			const viewportWidth = viewport.offsetWidth || 1;

			if ( setWidth <= 0 ) {
				return;
			}

			const moveBy = setWidth + gap;
			const setsToAdd = Math.ceil( viewportWidth / moveBy ) + 1;
			const rowDirection = $viewport.data( 'row-direction' ) === 'right' ? 'right' : 'left';

			for ( let i = 0; i < setsToAdd; i++ ) {
				$origItems
					.clone()
					.addClass( 'trs-tc-item--clone' )
					.attr( 'aria-hidden', 'true' )
					.appendTo( $track );
			}

			track.style.setProperty( '--trs-tc-move', moveBy + 'px' );

			if ( rowDirection === 'right' ) {
				$track.addClass( 'trs-tc-track--rtl' );
				track.style.transform = 'translateX(-' + moveBy + 'px)';
			}

			$track.addClass( 'trs-tc-track--animated' );
		};

		const rebuildAllRows = () => {
			$rowViewports.each( function() {
				buildRow( $( this ) );
			} );
		};

		rebuildAllRows();

		if ( pauseOnHover ) {
			$widget
				.on( 'mouseenter.trs-tc focusin.trs-tc', () => {
					$widget.find( '.trs-tc-row-track' ).addClass( 'trs-tc-track--paused' );
				} )
				.on( 'mouseleave.trs-tc focusout.trs-tc', () => {
					$widget.find( '.trs-tc-row-track' ).removeClass( 'trs-tc-track--paused' );
				} );
		}

		let resizeTimer;
		$( window ).on( 'resize.trs-tc-' + $scope.data( 'id' ), () => {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( rebuildAllRows, 250 );
		} );
	};

	$( window ).on( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-testimonial-cards.default',
			initTestimonials
		);
	} );
} )( jQuery );
