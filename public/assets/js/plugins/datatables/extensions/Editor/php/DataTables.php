<?php
/**
 * DataTables PHP libraries.
 *
 * PHP libraries for DataTables and DataTables Editor, utilising PHP 5.3+.
 *
 *  @author    SpryMedia
 *  @copyright 2012 SpryMedia ( http://sprymedia.co.uk )
 *  @license   http://editor.datatables.net/license DataTables Editor
 *  @link      http://editor.datatables.net
 */

define("DATATABLES", true, true);

//
// Error checking - check that we are PHP 5.3 or newer
//
if ( version_compare( PHP_VERSION, "5.3.0", '<' ) ) {
	echo json_encode( array(
		"sError" => "Editor PHP libraries required PHP 5.3 or newer. You are ".
			"currently using ".PHP_VERSION.". PHP 5.3 and newer have a lot of ".
			"great new features that the Editor libraries take advantage of to ".
			"present an easy to use and flexible API."
	) );
	exit(0);
}


//
// Load the DataTables bootstrap core file and let it register the required 
// handlers.
//
include( dirname(__FILE__).'/Bootstrap.php' );

