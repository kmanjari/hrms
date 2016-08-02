<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;


/*
 * Example PHP implementation used for the join.html example
 */
$data = Editor::inst( $db, 'users' )
              ->field(
	              Field::inst( 'users.first_name' ),
	              Field::inst( 'users.last_name' ),
	              Field::inst( 'users.phone' ),
	              Field::inst( 'users.site' ),
	              Field::inst( 'sites.name' )
              )
              ->leftJoin( 'sites', 'sites.id', '=', 'users.site' )
              ->process( $_POST )
              ->data();

if ( ! isset( $_POST['action'] ) ) {
	// Get a list of sites for the `select` list
	$data['sites'] = $db
		->selectDistinct( 'sites', 'id as value, name as label' )
		->fetchAll();
}


echo json_encode( $data );
