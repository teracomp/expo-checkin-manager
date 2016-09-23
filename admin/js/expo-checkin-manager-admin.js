/*global ajaxurl */
(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {

	 	// tabs
		var $tabBoxes = $('.ecim-metaboxes'),
			$currentTab,
			$tabContent,
//			$tabLinkActive,
//			$currentTabLink,
//			$showChild = $(".show-child-if-checked"),
			$hash;

		// Tabs on load
	 	if(window.location.hash){
	 		$hash = window.location.hash;
	 		$tabBoxes.addClass('hidden');
			$currentTab = $($hash).toggleClass('hidden');
			$('.nav-tab').removeClass('nav-tab-active');
			$('.nav-tab[href='+$hash+']').addClass('nav-tab-active');
	 	}
	 	//Tabs on click
	 	$('.nav-tab-wrapper').on('click', 'a', function(e){
			e.preventDefault();
			$tabContent = $(this).attr('href');
			$('.nav-tab').removeClass('nav-tab-active');
			$tabBoxes.addClass('hidden');
			$currentTab = $($tabContent).toggleClass('hidden');
			$(this).addClass('nav-tab-active');
			 if(history.pushState) {
				history.pushState(null, null, $tabContent);
			}
			else {
				location.hash = $tabContent;
			}
		});
			
		// update the current form option in both the manager object and the options table
		$('.gflist').change( function(e) {
			e.preventDefault();
			$.post( ajaxurl, 
				{	
					'action' : 'set_selected_form', 
					'form_id'  : e.srcElement.value
				}
			);			
		});
		
		// monitor file selection process, enable the import button when a file is selected
		$('#csv_import_file').change( function(e) {
			e.preventDefault();
			console.log( 'import csv file selected.' );
			$('#import_csv_sheet_btn').prop('disabled',false);
		});

		// import the file from above
		$('#frm_import_sheet').submit( function( e ) {
			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				success: function( results ) {
					$('#import_results').html( results );
					console.log('results: ' + results );
				}
			});
			e.preventDefault();
		});
	
		
		// test to see if the page I want is loaded
//		if ( ( $('#expo-settings').length > 0 ) || ( $('#import-sheets').length > 0 ) ) {
//			$.post( ajaxurl, 
//				{	
//					'action' : 'get_form_fields', 
//					'form_id' : 0,
//					'text'    : ''
//				}, 
//				function( fieldList ) {
//					$('#fieldList').html( fieldList );
//					console.log('show curr form fields');				
//				}
//			);
//			
//			$.post( ajaxurl, 
//				{ 
//					'action' : 'get_dbtable_columns',
//					'tablename' :  'expo_checkin_tmp'
//				},
//				function( columnList ) {
//					$('#dbTableColumns').html( columnList );
//					console.log('show tmp db columns');
//			});
//		}
	
	});

})( jQuery );
