<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;


/*
 * Example PHP implementation used for the joinSelf.html example - the basic idea
 * here is that the join performed is simply to get extra information about the
 * 'manager' (in this case, the name of the manager). To alter the manager for
 * a user, you would change the 'manager' value in the 'users' table, so the
 * information from the join is read-only.
 */
$out = Editor::inst( $db, 'users' )
             ->field(
	             Field::inst( 'users.first_name' ),
	             Field::inst( 'users.last_name' ),
	             Field::inst( 'users.manager' ),
	             Field::inst( 'manager.first_name' ),
	             Field::inst( 'manager.last_name' )
             )
             ->leftJoin( 'users as manager', 'users.manager', '=', 'manager.id' )
             ->process( $_POST )
             ->data();


// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data back to the client, with the options
// for the 'department' select list and 'access' radio boxes
if ( ! isset( $_POST['action'] ) ) {
	$userList = $db->select( 'users', 'id, first_name, last_name' );

	$out['userList'] = array();
	while ( $row = $userList->fetch() ) {
		$out['userList'][] = array(
			"value" => $row['id'],
			"label" => $row['id'] . ' ' . $row['first_name'] . ' ' . $row['last_name']
		);
	}
}

// Send it back to the client
echo json_encode( $out );

