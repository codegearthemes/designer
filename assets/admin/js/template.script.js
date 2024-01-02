( function( elementor, $ ) {

	elementor.on('document:loaded', function() {

		var previewContents = elementor.$previewContents;

		const $libraryButton = $('<div />');
		$libraryButton.addClass('elementor-add-section-area-button block-template__button');
		$libraryButton.attr( 'title', 'Add Starter Template' );
		$libraryButton.html( '<img width="24" height="24" src="' + designer_templates_library.logo + '" />' );
		$libraryButton.insertAfter( previewContents.find('.elementor-add-section-area-button.elementor-add-template-button') );

	});

} )( elementor, jQuery, window );
