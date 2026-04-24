( function ( $ ) {
	'use strict';

	/**
	 * Initialise a Jobs Cards widget instance.
	 *
	 * Currently the widget is fully CSS-driven (hover gradients, transitions).
	 * This hook exists so custom JS behaviour can be attached per-scope
	 * and survives Elementor editor reloads without duplication.
	 *
	 * @param {jQuery} $scope - The Elementor widget wrapper element.
	 */
	const initJobsCards = function ( $scope ) {
		const $grid = $scope.find( '.trs-jobs-cards__grid' );

		if ( ! $grid.length ) {
			return;
		}

		// Ensure equal card heights within each row when the grid has
		// multiple columns and natural heights differ.
		equaliseCardHeights( $scope );

		$( window ).on( 'resize.trsJobsCards', debounce( function () {
			equaliseCardHeights( $scope );
		}, 150 ) );
	};

	/**
	 * Reset inline heights then re-apply equal heights row by row.
	 *
	 * @param {jQuery} $scope
	 */
	function equaliseCardHeights( $scope ) {
		const $cards = $scope.find( '.trs-jobs-card' );

		// Reset so we measure natural heights.
		$cards.css( 'height', '' );

		// Group cards by their top offset (= same row).
		const rows = {};
		$cards.each( function () {
			const top = $( this ).offset().top;
			if ( ! rows[ top ] ) {
				rows[ top ] = [];
			}
			rows[ top ].push( this );
		} );

		// Apply max height per row.
		$.each( rows, function ( _top, group ) {
			if ( group.length < 2 ) {
				return;
			}
			let max = 0;
			$( group ).each( function () {
				max = Math.max( max, $( this ).outerHeight() );
			} );
			$( group ).css( 'height', max + 'px' );
		} );
	}

	/**
	 * Simple debounce helper.
	 *
	 * @param {Function} fn
	 * @param {number}   wait
	 * @returns {Function}
	 */
	function debounce( fn, wait ) {
		let timer;
		return function () {
			clearTimeout( timer );
			timer = setTimeout( fn, wait );
		};
	}

	// Register with Elementor frontend.
	$( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-jobs-cards.default',
			initJobsCards
		);
	} );

} )( jQuery );
