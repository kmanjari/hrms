
/*global SyntaxHighlighter,editor*/

$(document).ready( function () {
	//
	// Modify the tabs from the DataTables default examples to show the
	// extras information we want for Editor
	//

	// Ajax load data - rename and move to the end
	$('ul.tabs li').eq(3).html('Ajax load').appendTo( 'ul.tabs' );
	$('div.tabs > div').eq(3).appendTo( 'div.tabs' );

	// Ajax data interchange between Editor and the server
	$('ul.tabs').append( '<li>Ajax data</li>' );
	$(
		'<div class="ajax-data">'+
			'<p>Editor submits and retrieves information by Ajax requests. The two blocks below show the data that Editor submits and receives, to and from the server. This is updated live as you interact with Editor so you can see what is submitted.</p>'+
			'<div class="column_half ajax-data-send">'+
				'<h3>Submitted data:</h3>'+
				'<p>The following shows the data that has been submitted to the server when a request is made to add, edit or delete data from the table.</p>'+
				'<code class="multiline brush: php;">// No data yet submitted</code>'+
			'</div>'+
			'<div class="column_half ajax-data-receive">'+
				'<h3>Server response:</h3>'+
				'<p>The following shows the data that has been returned by the server in response to the data submitted on the left and is then acted upon.</p>'+
				'<code class="multiline brush: php;">// No data yet received</code>'+
			'</div>'+
			'<div class="clear"></div>'+
		'</div>'
	).appendTo( 'div.tabs' );

	// Wait for Editor to come ready
	$(document)
		.off( 'init.dt.demoSSP' )
		.on( 'init.dt.demoSSP', function () {
			/* Show and syntax highlight submit and return data */
			editor.on('preSubmit', function (e, data) {
				$('div.ajax-data-send div.syntaxhighlighter').remove();
				$('div.ajax-data-send').append(
					'<code class="multiline brush: js;">'+
						decodeURI(
							jQuery.param( data ).replace(/&/g, '\n').replace(/\+/g, ' ')
						)+
					'</code>'
				);
				SyntaxHighlighter.highlight( {}, $('div.ajax-data-send code')[0] );
			} );

			editor.on('postSubmit', function (e, json, data) {
				$('div.ajax-data-receive div.syntaxhighlighter').remove();
				$('div.ajax-data-receive').append(
					'<code class="multiline brush: js;">'+JSON.stringify( json, null, 2 )+'</code>'
				);
				SyntaxHighlighter.highlight( {}, $('div.ajax-data-receive code')[0] );
			} );

			// Server-side script - replace the DataTables script display with
			// one customised for Editor. This is actually tab index 4 from the
			// DT tabs, but due to the reorder above it gets moved down one
			$('ul.tabs li').eq(3).html('Server script').css('display', 'block');
			var server = $('div.tabs > div').eq(3);
			var table = $('#example').DataTable();

			server.find('p').eq(0).html( 'The following script is used by DataTables and Editor to process the data requests sent by the client on the server-side.' );

			$.ajax( {
				url: '../resources/examples.php',
				data: {
					src: table.ajax.url() ||  '../php/staff-array.php'
				},
				dataType: 'text',
				type: 'post',
				success: function ( txt ) {
					$('div.tabs > div.php').append(
						'<code class="multiline brush: php;">'+txt+'</code>'
					);
					SyntaxHighlighter.highlight( {}, $('div.tabs div.php code')[0] );
				}
			} );
	} );
} );

