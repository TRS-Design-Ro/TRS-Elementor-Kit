( function( $ ) {
	'use strict';

	const initModernBentoCards = ( $scope ) => {
		const $cards = $scope.find( '.trs-modern-bento-cards .trs-mbc-card' );
		if ( ! $cards.length ) {
			return;
		}

		$cards.each( function() {
			const $card = $( this );
			$card.on( 'touchstart', () => {
				$card.addClass( 'is-touch-active' );
			} );
			$card.on( 'touchend touchcancel', () => {
				$card.removeClass( 'is-touch-active' );
			} );
		} );
	};

	$( window ).on( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/trs-modern-bento-cards.default',
			initModernBentoCards
		);
	} );
} )( jQuery );
