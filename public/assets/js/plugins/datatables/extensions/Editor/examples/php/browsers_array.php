<?php

/*
 * Example PHP implementation used for the htmlTable.php example where
 * the information from the table is returned as an array (indexes) rather
 * than as JSON object properties, since the table is read from the DOM as
 * an array.
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
Editor::inst( $db, 'browsers' )
	->fields(
		Field::inst( 'engine', 0 )->validator( 'Validate::required' ),
		Field::inst( 'browser', 1 )->validator( 'Validate::required' ),
		Field::inst( 'platform', 2 ),
		Field::inst( 'version', 3 ),
		Field::inst( 'grade', 4 )->validator( 'Validate::required' )
	)
	->process( $_POST )
	->json();
