<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Format;

// Build our Editor instance and process the data coming from _POST
$out = Editor::inst( $db, 'datatables_demo' )
             ->fields(
	             Field::inst( 'id' )->set( false ), // ID is automatically set as the primary key
	             Field::inst( 'first_name' )->validator( 'Validate::notEmpty' ),
	             Field::inst( 'last_name' )->validator( 'Validate::notEmpty' ),
	             Field::inst( 'position' ),
	             Field::inst( 'email' ),
	             Field::inst( 'office' ),
	             Field::inst( 'extn' )->validator( 'Validate::numeric' ),
	             Field::inst( 'age' )->validator( 'Validate::numeric' ),
	             Field::inst( 'salary' )->validator( 'Validate::numeric' ),
	             Field::inst( 'start_date' )
	                  ->validator( 'Validate::dateFormat', array(
		                  "format"  => Format::DATE_ISO_8601,
		                  "message" => "Please enter a date in the format yyyy-mm-dd"
	                  ) )
	                  ->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
	                  ->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )
             )
             ->process( $_POST )
             ->data();

// On 'Get' remove the DT_RowId property so we can see fully how the `idSrc`
// option works on the client-side.
if ( ! isset( $_POST['action'] ) ) {
	for ( $i = 0, $ien = count( $out['data'] ); $i < $ien; $i ++ ) {
		unset( $out['data'][ $i ]['DT_RowId'] );
	}
}

// Send it back to the client
echo json_encode( $out );
