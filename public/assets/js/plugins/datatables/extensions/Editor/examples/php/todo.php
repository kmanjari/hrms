<?php

/*
 * Example PHP implementation for the client-side table formatting example.
 * This is basically the same as the 'fieldTypes' example, but in this case
 * note that there is no server-side formatting of the 'done' field - rather it
 * is done in the DataTable in this example
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
Editor::inst( $db, 'todo' )
	->fields(
		Field::inst( 'item' ),
		Field::inst( 'done' ),
		Field::inst( 'priority' )
	)
	->process( $_POST )
	->json();

