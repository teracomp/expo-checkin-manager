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
			$hash,
			ajax_url = '/gf/wp-admin/admin-ajax.php';


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
		
		$('#button1').click( function(e) {
			e.preventDefault();
			console.log('inside click');
			// importFile = $('input[type=file]').val(),
			var 	input = $('#csv_import_file'),
				file,
				fr,
				importFileContents;
			if ( !input.files ) {
				file = 'unknown file...something broke.';
			} else {
				file = input.files[0];
				fr = new FileReader();
//				fr.onload = receivedText;
				fr.readAsText(file);
				importFileContents = fr.result;
			}
			
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: {
					action: 'post_type_search_callback',
					variable: 'file: ' + file + ' contents:' + importFileContents
				},
				success: function( output ) {
					console.log('success: ' + output );
				}
				
			});
		});

		$('#chkbox1').click( function(e) {
			e.preventDefault();
			console.log('checkbox1');
			$.ajax({
				type: "POST",
				url: "/gf/wp-admin/admin-ajax.php",
				data: {
					action: 'chkbox1_callback',
					variable: 'chkbox1' // $_POST['variable']
				},
				success: function( output ) {
					console.log('success: ' + output );
				}
				
			});
		});
	
	});

})( jQuery );
/*

jQuery(document).ready(function() { // wait for page to finish loading 
	'use strict';
   jQuery("#button1").click(function () {
	   
console.log('clicked!');
    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php",
        data: {
            action: 'post_type_search_callback',
            variable: 45 // enter in anyname here instead of variable, you will need to catch this value using $_POST['variable'] in your php function.
        },
        success: function (output) {
           console.log(output);
        }
    });

  });
});

*/
