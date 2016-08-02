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


namespace DataTables;
if (!defined('DATATABLES')) exit();


//
// Configuration
//   Load the database connection configuration options
//
include( dirname(__FILE__).'/config.php' );


//
// Auto-loader
//   Automatically loads DataTables classes
//
spl_autoload_register( function ($class) {
	$a = explode("\\", $class);

	// Are we working in the DataTables namespace
	if ( $a[0] !== "DataTables" ) {
		return;
	}

	if ( count( $a ) === 2 ) {
		// If just a single top level namespace is given, then we just need to
		// include the class from its own Directory
		//syslog( LOG_INFO, dirname(__FILE__).'/'.$a[1].'/'.$a[1].'.php' );
		require( dirname(__FILE__).'/'.$a[1].'/'.$a[1].'.php' );
	}
	else if ( count( $a ) === 3 ) {
		// If a sub-namespace is used, then we can use A-Z to separate classes in
		// that namespace
		preg_match_all( "/[A-Z]+[^A-Z]*/", $a[2], $matches );
		$location = implode( '/', $matches[0] );

		//syslog( LOG_INFO, dirname(__FILE__).'/'.$a[1].'/'.$location.'.php' );
		require( dirname(__FILE__).'/'.$a[1].'/'.$location.'.php' );
	}
} );


//
// Database connection
//   Database connection is globally available
//
$db = new Database( $sql_details );

