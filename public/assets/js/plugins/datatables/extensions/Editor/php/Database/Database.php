<?php
/**
 * DataTables PHP libraries.
 *
 * PHP libraries for DataTables and DataTables Editor, utilising PHP 5.3+.
 *
 * @author    SpryMedia
 * @copyright 2012 SpryMedia ( http://sprymedia.co.uk )
 * @license   http://editor.datatables.net/license DataTables Editor
 * @link      http://editor.datatables.net
 */

namespace DataTables;
if ( ! defined( 'DATATABLES' ) ) {
	exit();
}

use DataTables\Database\Query;
use DataTables\Database\Result;


/**
 * DataTables Database connection object.
 *
 * Create a database connection which may then have queries performed upon it.
 *
 * This is a database abstraction class that can be used on multiple different
 * databases. As a result of this, it might not be suitable to perform complex
 * queries through this interface or vendor specific queries, but everything
 * required for basic database interaction is provided through the abstracted
 * methods.
 */
class Database {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/** @var resource */
	private $_db = null;



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */

	/**
	 * Database instance constructor.
	 *
	 * @param string[] $opts Array of connection parameters for the database:
	 *    <code>
	 *      array(
	 *          "user" => "", // User name
	 *          "pass" => "", // Password
	 *          "host" => "", // Host name
	 *          "port" => "", // Port
	 *          "db"   => "", // Database name
	 *          "type" => ""  // Datable type: "Mysql", "Postgres" or "Sqlite"
	 *      )
	 *    </code>
	 */
	function __construct( $opts ) {
		$this->query_driver = "DataTables\\Database\\Driver" . $opts['type'] . 'Query';
		$this->_db          = call_user_func( $this->query_driver . '::connect', $opts );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	/**
	 * Commit a database transaction.
	 *
	 * Use with {@link transaction} and {@link rollback}.
	 * @return self
	 */
	public function commit() {
		call_user_func( $this->query_driver . '::commit', $this->_db );

		return $this;
	}


	/**
	 * Perform a delete query on a table.
	 *
	 * This is a short cut method that creates an update query and then uses
	 * the query('delete'), table, where and exec methods of the query.
	 *
	 * @param string|string[] $table Table name(s) to act upon.
	 * @param array $where Where condition for what to delete - see {@link
	 *    Query::where}.
	 *
	 * @return Result
	 */
	public function delete( $table, $where = null ) {
		return $this->query( 'delete' )
		            ->table( $table )
		            ->where( $where )
		            ->exec();
	}

	/**
	 * Create a query object to build a database query.
	 *
	 * @param string $type Query type - select, insert, update or delete.
	 * @param string|string[] $table Table name(s) to act upon.
	 *
	 * @return Query
	 */
	public function query( $type, $table = null ) {
		return new $this->query_driver( $this->_db, $type, $table );
	}

	/**
	 * Update or Insert data. When doing an insert, the where condition is
	 * added as a set field
	 *
	 * @param string|string[] $table Table name(s) to act upon.
	 * @param array $set Field names and values to set - see {@link
	 *    Query::set}.
	 * @param array $where Where condition for what to delete - see {@link
	 *    Query::where}.
	 *
	 * @return Result
	 */
	public function push( $table, $set, $where = null ) {
		// Update or insert
		if ( $this->select( $table, "*", $where )->count() > 0 ) {
			return $this->update( $table, $set, $where );
		}

		// Add the where condition to the values to set
		foreach ( $where as $key => $value ) {
			$set[ $key ] = $value;
		}

		return $this->insert( $table, $set );
	}

	/**
	 * Select data from a table.
	 *
	 * This is a short cut method that creates an update query and then uses
	 * the query('select'), table, get, where and exec methods of the query.
	 *
	 * @param string|string[] $table Table name(s) to act upon.
	 * @param array $field Fields to get from the table(s) - see {@link
	 *    Query::get}.
	 * @param array $where Where condition for what to delete - see {@link
	 *    Query::where}.
	 * @param array $orderBy Order condition - see {@link
	 *    Query::order}.
	 *
	 * @return Result
	 */
	public function select( $table, $field = "*", $where = null, $orderBy = null ) {
		return $this->query( 'select' )
		            ->table( $table )
		            ->get( $field )
		            ->where( $where )
		            ->order( $orderBy )
		            ->exec();
	}

	/**
	 * Update data.
	 *
	 * This is a short cut method that creates an update query and then uses
	 * the query('update'), table, set, where and exec methods of the query.
	 *
	 * @param string|string[] $table Table name(s) to act upon.
	 * @param array $set Field names and values to set - see {@link
	 *    Query::set}.
	 * @param array $where Where condition for what to delete - see {@link
	 *    Query::where}.
	 *
	 * @return Result
	 */
	public function update( $table, $set = null, $where = null ) {
		return $this->query( 'update' )
		            ->table( $table )
		            ->set( $set )
		            ->where( $where )
		            ->exec();
	}

	/**
	 * Insert data into a table.
	 *
	 * This is a short cut method that creates an update query and then uses
	 * the query('insert'), table, set and exec methods of the query.
	 *
	 * @param string|string[] $table Table name(s) to act upon.
	 * @param array $set Field names and values to set - see {@link
	 *    Query::set}.
	 *
	 * @return Result
	 */
	public function insert( $table, $set ) {
		return $this->query( 'insert' )
		            ->table( $table )
		            ->set( $set )
		            ->exec();
	}

	/**
	 * Quote a string for a quote. Note you should generally use a bind!
	 *
	 * @param string $val Value to quote
	 * @param string $type Value type
	 *
	 * @return string
	 */
	public function quote( $val, $type = \PDO::PARAM_STR ) {
		return $this->_db->quote( $val, $type );
	}

	/**
	 * Rollback the database state to the start of the transaction.
	 *
	 * Use with {@link transaction} and {@link commit}.
	 * @return self
	 */
	public function rollback() {
		call_user_func( $this->query_driver . '::rollback', $this->_db );

		return $this;
	}

	/**
	 * Select data from a table.
	 *
	 * This is a short cut method that creates an update query and then uses
	 * the query('select'), table, get, where and exec methods of the query.
	 *
	 * @param string|string[] $table Table name(s) to act upon.
	 * @param array $field Fields to get from the table(s) - see {@link
	 *    Query::get}.
	 * @param array $where Where condition for what to delete - see {@link
	 *    Query::where}.
	 * @param array $orderBy Order condition - see {@link
	 *    Query::order}.
	 *
	 * @return Result
	 */
	public function selectDistinct( $table, $field = "*", $where = null, $orderBy = null ) {
		return $this->query( 'select' )
		            ->table( $table )
		            ->distinct( true )
		            ->get( $field )
		            ->where( $where )
		            ->order( $orderBy )
		            ->exec();
	}

	/**
	 * Execute an raw SQL query - i.e. give the method your own SQL, rather
	 * than having the Database classes building it for you.
	 *
	 * @param string $sql SQL string to execute (only if _type is 'raw').
	 *
	 * @return Result
	 *
	 * @example
	 *    Basic select
	 *    <code>
	 *    $result = $db->sql( 'SELECT * FROM myTable;' );
	 *    </code>
	 *
	 * @example
	 *    Set the character set of the connection
	 *    <code>
	 *    $db->sql("SET character_set_client=utf8");
	 *    $db->sql("SET character_set_connection=utf8");
	 *    $db->sql("SET character_set_results=utf8");
	 *    </code>
	 */
	public function sql( $sql ) {
		return $this->query( 'raw' )
		            ->exec( $sql );
	}

	/**
	 * Start a new database transaction.
	 *
	 * Use with {@link commit} and {@link rollback}.
	 * @return self
	 */
	public function transaction() {
		call_user_func( $this->query_driver . '::transaction', $this->_db );

		return $this;
	}
}

;

