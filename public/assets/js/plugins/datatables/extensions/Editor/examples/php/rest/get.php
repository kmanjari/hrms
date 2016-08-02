<?php

/*
 * Example PHP implementation used for the REST 'get' interface
 */

include( "staff-rest.php" );

$editor
	->process($_POST)
	->json();

