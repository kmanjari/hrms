<?php

/*
 * Example PHP implementation used for the REST 'create' interface.
 */

include( "staff-rest.php" );

$editor
	->process( $_POST )
	->json();

