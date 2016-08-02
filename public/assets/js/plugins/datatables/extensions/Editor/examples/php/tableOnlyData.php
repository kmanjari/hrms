<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'users' )
      ->fields(
	      Field::inst( 'first_name' ),
	      Field::inst( 'last_name' ),
	      Field::inst( 'updated_date' )
	           ->set( false )
	           ->getFormatter( 'Format::date_sql_to_format', 'D, jS F Y' )
      )
      ->process( $_POST )
      ->json();

