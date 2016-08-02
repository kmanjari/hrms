<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'datatables_demo' )
	->fields(
		Field::inst( 'first_name', 0 )->validator( 'Validate::notEmpty' ),
		Field::inst( 'last_name', 1 )->validator( 'Validate::notEmpty' ),
		Field::inst( 'position', 2 ),
		Field::inst( 'office', 3 ),
		Field::inst( 'salary', 4 )
			->validator( 'Validate::numeric' )
			->getFormatter( function ( $val ) {
				return '$'.number_format($val);
			} )
	)
	->process( $_POST )
	->json();
