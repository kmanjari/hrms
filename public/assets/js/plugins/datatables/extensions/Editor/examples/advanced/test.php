<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;


/*
 * Example PHP implementation used for the join.html example
 */
$out = Editor::inst( $db, 'users' )
	->field( 
		Field::inst( 'users.first_name' ),
		Field::inst( 'users.last_name' ),
		Field::inst( 'users.site' ),
		Field::inst( 'sites.name' ),
		Field::inst( 'user_dept.dept_id' ),
		Field::inst( 'dept.name' )
	)
	->leftJoin( 'sites',     'sites.id',          '=', 'users.site' )
	->leftJoin( 'user_dept', 'users.id',          '=', 'user_dept.user_id' )
	->leftJoin( 'dept',      'user_dept.dept_id', '=', 'dept.id' )
	->process($_POST)
	->data();

// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data back to the client, with the options
// for the 'sites' and 'dept' select lists
if ( !isset($_POST['action']) ) {
    // Get a list of sites for the `select` list
    $out['sites'] = $db
        ->selectDistinct( 'sites', 'id as value, name as label' )
        ->fetchAll();

	// Get department details
	$out['dept'] = $db
		->select( 'dept', 'id as value, name as label' )
		->fetchAll();
}

// Send it back to the client
echo json_encode( $out );

