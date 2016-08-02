<?php

/*
 * Example PHP implementation used for the formOnlyData.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'users' )
      ->fields(
	      Field::inst( 'title' ),
	      Field::inst( 'first_name' ),
	      Field::inst( 'last_name' ),
	      Field::inst( 'phone' ),
	      Field::inst( 'city' ),
	      Field::inst( 'zip' ),
	      Field::inst( 'comments' )
      )
      ->process( $_POST )
      ->json();

