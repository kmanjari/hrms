<?php
/**
 * SQL Server driver for DataTables PHP libraries
 *
 * @author    SpryMedia
 * @copyright 2013 SpryMedia ( http://sprymedia.co.uk )
 * @license   http://editor.datatables.net/license DataTables Editor
 * @link      http://editor.datatables.net
 */

namespace DataTables\Database;
if ( ! defined( 'DATATABLES' ) ) {
	exit();
}

use PDO;


/**
 * SQL Server driver for DataTables Database Result class
 * @internal
 */
class DriverSqlserverResult extends Result {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	private $_stmt;


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */
	private $_dbh;

	function __construct( $dbh, $stmt ) {
		$this->_dbh  = $dbh;
		$this->_stmt = $stmt;
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	public function count() {
		return count( $this->fetchAll() );
	}

	public function fetchAll() {
		return $this->_stmt->fetchAll( \PDO::FETCH_ASSOC );
	}

	public function fetch() {
		return $this->_stmt->fetch( \PDO::FETCH_ASSOC );
	}

	public function insertId() {
		return $this->_dbh->lastInsertId();
	}
}

