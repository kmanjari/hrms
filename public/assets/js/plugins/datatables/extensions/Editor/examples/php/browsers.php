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
Editor::inst( $db, 'browsers' )
	->fields(
		Field::inst( 'engine' )->validator( 'Validate::required' ),
		Field::inst( 'browser' )->validator( 'Validate::required' ),
		Field::inst( 'platform' ),
		Field::inst( 'version' ),
		Field::inst( 'grade' )->validator( 'Validate::required' )
	)
	->process( $_POST )
	->json();
