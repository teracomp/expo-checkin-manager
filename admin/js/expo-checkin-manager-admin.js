/*global ajaxurl */
(function( $ ) {
	'use strict';

	$(function() {

		// wait for ms time to respond to user function
		var delay = ( function() {
			var timer=0;
			return function( callback, ms) {
				clearTimeout( timer );
				timer = setTimeout( callback, ms);
			};
		})();
				
		// update the current form option in both the manager object and the options table
		$('.gflist').change( function(e) {
			e.preventDefault();
			$.post( ajaxurl, 
				{	
					'action' : 'set_selected_form', 
					'form_id'  : e.srcElement.value
				},
				function() {
					console.log('Selected form ' + e.srcElement.value);
				}
			);			
		});
		
		// monitor file selection process, enable the import button when a file is selected
		$('#csv_import_file').change( function(e) {
			e.preventDefault();
			console.log( 'import csv file selected.' );
			var f = this.files[0];
			if ( f ) {
				var reader = new FileReader();
				reader.onload = function( theFile ) {	
					var content = theFile.target.result;				// get the file content
					var headerRow = content.split(/[\r\n]/g)[0];		// get the header row
					var headerArray = headerRow.split(',');
					for ( var i=0; i<headerArray.length; i++) {
						headerArray[i] = headerArray[i].trim();
					}
					var badColumnName = checkHeader( headerArray );
					if ( badColumnName.length > 0 ) {
						console.log('bad column name: ' + badColumnName );
						$('#import_csv_sheet_btn').prop('disabled',true);
						$('#importMsg').html('<h3>Bad Column Name Found!</h3><p>Please fix: <span style="color:red;"><strong><em>' + 
							badColumnName + '</strong></em></span> and try again.</p>');
					} else {
						$('#importMsg').html('<h3>Ready to import ' + f.name + '</h3>');
					}
				};
				reader.readAsText(f);			
			} else {
				console.log('Failed to load file');
			}
			$('#import_csv_sheet_btn').prop('disabled',false);
		});

		function checkHeader( ar ) {
			var badColumn = '';
			var validColumns = Array( 'group_name', 'group_total', 'regtype', 'regreason', 'payment_status', 'source',
        			'firstname', 'lastname', 'email', 'address', 'city', 'state', 'zip', 'phone', 'precon',
            		'spouse_firstname', 'spouse_lastname', 'spouse_email', 'spouse_precon', 'notes' );
			for ( var i=0; i<ar.length; i++ ) {
				if ( validColumns.indexOf(ar[i]) < 0 ) {
					badColumn = ar[i];
					break;
				}
			}
			
			return badColumn;
		}

		// import the file from above
		$('#frm_import_sheet').submit( function( e ) {
			console.log('Import Sheet clicked, form submitted');
			var msg = $('#importMsg').html();
			msg += '<hr /><p>importing...hang on...</p>';
			$('#importMsg').html(msg);
			$('#import_waiting').css('display', 'block');
			
			$('#import_csv_sheet_btn').prop('disabled', true);
			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				success: function( results ) {
					$('#importMsg').html('');
					$('#import_waiting').css('display', 'none');
					$('#import_results').html( results );
					console.log('results: ' + results );
					$('#csv_import_file').val('');
//					$('#import_csv_sheet_btn').prop('disabled', false);		
				}
			});
			e.preventDefault();
		});
		
	
		// monitor changes to the filename.
		// if the user stops for 1000ms, the action is fired
		// show a message in the status div when complete for 3000ms
		$('#export_csv_filename').keyup( function(e) {
			delay(function() {
				console.log('time elapsed!');
				$.post( ajaxurl, 
					{ 
						'action' : 'set_export_filename', 
						'csv_filename' : e.srcElement.value 
					}, 
					function( response ) { 
						console.log('Set CSV Filename: ' + e.srcElement.value); 
						$('#export_csv_filename_status').html( response );
						$('#export_csv_btn').prop('disabled', false);		
						delay( function() {
							$('#export_csv_filename_status').html('');
						}, 3000);
					}
				);
			}, 1000 );
		});
		
		// disable the "Create File" button as soon as the user starts typing in either
		// #export_csv_filename or #last_export_entry_id input boxes
		$('#export_csv_filename, #last_export_entry_id').keydown( function() {
			$('#export_csv_btn').prop('disabled', true);
			if ( $(this).is('#last_export_entry_id') ) {
				$('#last_export_ok').css('display', 'block');
			}
		});
	
		// this button gives the user something to click after changing the entry id number
		// which fires the change event for the input field
		$('#last_export_ok_btn').click( function(e) {
			console.log('ok btn clicked');
			e.preventDefault();
		});
		
		// update the options table with the new last_export_entry_id
		$('#last_export_entry_id').change( function(e) {
			console.log('changed starting entry id');
			$.post( ajaxurl, 
				{ 
					'action' : 'set_export_entry_id', 
					'entry_id' : e.srcElement.value 
				}, 
				function( response ) {
					console.log('successfully changed the entry id');
					$('#export_csv_btn').attr('disabled', false);		
					$('#last_export_ok').css('display', 'none');
					console.log('response: ' + response); // might update the user interface in the future
				}
			);			
		});
	
		// export registrants to csv file
		$('#export_csv_btn').click( function( e ) {
			e.preventDefault();
			$('#export_csv_btn').prop('disabled', true);
			$('#export_waiting').css('display', 'block');
			console.log('export_csv_btn clicked! csv file should happen soon!!');
			$.post( ajaxurl,
				{
					'action' : 'export_entries'
				},
				function( response ) {
					console.log('Export Sheet responded' );
					$('#export_waiting').css('display', 'none');
					$('#export_csv_results').html( response );
				}
			);
		});
		
		
		//
		// update entries processes
		//

		// monitor file selection process, enable the import button when a file is selected
		$('#csv_update_file').change( function(e) {
			e.preventDefault();
			console.log( 'update csv file selected.' );
			var f = this.files[0];
			if ( f ) {
				var reader = new FileReader();
				reader.onload = function( theFile ) {	
					var content = theFile.target.result;				// get the file content
					var data = content.split(/[\r\n]/g);		// get the header row
					console.log('data length: ' + data.length);
					if ( data.length === 0 ) {
						console.log('bad data');
						$('#update_entries_btn').prop('disabled',true);
						$('#update_results').html('<h3>Bad Data Found!</h3><p>Please fix and try again.</p>');
					} else {
						$('#update_results').html('<h3>Ready to update ' + data.length + ' entries with ' + f.name + '</h3>');
					}
				};
				reader.readAsText(f);			
			} else {
				console.log('Failed to load file');
			}
			$('#update_entries_btn').prop('disabled',false);
		});


		// import the file from above
		$('#frm_update_entries').submit( function( e ) {
			console.log('Update Entries clicked, form submitted via update_entries_btn');
			$('#update_waiting').css('display', 'block');
			
			$('#update_entries_btn').prop('disabled', true);
			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				success: function( results ) {
					$('#update_waiting').css('display', 'none');
					$('#update_results').html( results );
					console.log('should be successful' );
					$('#csv_update_file').val('');
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
