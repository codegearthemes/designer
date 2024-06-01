( function( $ ) {

	"use strict";

	
	// Elementor Editor Popup
	var DesignerElementorEditorPopup = {

		loaded: false,

		init: function() {
			window.elementor.on( 'preview:loaded', DesignerElementorEditorPopup.loadPreview );
		},

		loadPreview: function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-template.default', function( $scope ) {
				$scope.find( '.designer-template-edit-btn' ).on( 'click', DesignerElementorEditorPopup.renderPopup );
			} );

			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-tabs-horizontal.default', function( $scope ) {
				$scope.find( '.designer-template-edit-btn' ).on( 'click', DesignerElementorEditorPopup.renderPopup );
			} );
			
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-tabs-vertical.default', function( $scope ) {
				$scope.find( '.designer-template-edit-btn' ).on( 'click', DesignerElementorEditorPopup.renderPopup );
			} );

		},

		renderPopup: function( link ) {
			// Open Editor
			DesignerElementorEditorPopup.getPopup().show();

			// Render Iframe
			$( '#designer-template-editor-popup .dialog-message').html( '<iframe src="' + $( this ).data( 'permalink' ) + '&elementor' + '" id="designer-template-edit-frame" width="100%" height="100%"></iframe>' );
			
			// Preloading
			$( '#designer-template-editor-popup .dialog-message').append( '<div id="designer-template-editor-loading"><div class="elementor-loader-wrapper"><div class="elementor-loader"><div class="elementor-loader-boxes"><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div></div></div><div class="elementor-loading-title">Loading</div></div></div>' );

			// Loaded
			$( '#designer-template-edit-frame').on( 'load', function() {
				$( '#designer-template-editor-loading').fadeOut( 300 );
			} );

			// Close
			$( '#designer-template-editor-popup .dialog-close-button' ).css({
				'right' : '30px',
				'width' : '35px',
				'height' : '35px',
				'line-height' : '30px',
				'border-radius' : '50%',
				'text-align' : 'center',
				'opacity' : '1',
				'background-color' : '#333',
				'box-shadow' : '1px 1px 3px 0 #000',
			}).html( '<i class="eicon-close"></i>');

			$( '#designer-template-editor-popup .dialog-close-button i' ).css({
				'font-size' : '15px',
				'color' : '#fff',
			})

			$( '#designer-template-editor-popup .dialog-close-button' ).on( 'click', function() {
				elementor.reloadPreview();
			});
		},

		getPopup: function() {

			if ( ! DesignerElementorEditorPopup.loaded ) {
				this.loaded = elementor.dialogsManager.createWidget( 'lightbox', {
					id: 'designer-template-editor-popup',
					closeButton: true,
					hide: { onBackgroundClick: false }
				} );
			}

			return DesignerElementorEditorPopup.loaded;
		}

	};

	$( window ).on( 'elementor:init', DesignerElementorEditorPopup.init );

}( jQuery ) );