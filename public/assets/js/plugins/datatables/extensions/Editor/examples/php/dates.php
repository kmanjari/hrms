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
Editor::inst( $db, 'users' )
	->fields(
		Field::inst( 'first_name' ),
		Field::inst( 'last_name' ),
		Field::inst( 'updated_date' )
			->validator( 'Validate::dateFormat', array(
					"empty" => false,
					"format" => Format::DATE_ISO_8601,
					"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ),
		Field::inst( 'registered_date' )
			->validator( 'Validate::dateFormat', 'D, d M y' )
			->getFormatter( 'Format::date_sql_to_format', 'D, d M y' )
			->setFormatter( 'Format::date_format_to_sql', 'D, d M y' )
	)
	->process( $_POST )
	->json();

