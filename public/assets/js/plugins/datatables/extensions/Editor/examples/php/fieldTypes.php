<?php

/*
 * Example PHP implementation used for the todo list examples
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
		Field::inst( 'item', 'item' ),
		Field::inst( 'done', 'done' )
			->setFormatter( function ($val, $data, $field) {
				return $val == "Done" ? 1 : 0;
			} )
			->getFormatter( function ($val, $data, $field) {
				return $val == 0 ? "To do" : "Done";
			} ),
		Field::inst( 'priority', 'priority' )
	)
	->process( $_POST )
	->json();

