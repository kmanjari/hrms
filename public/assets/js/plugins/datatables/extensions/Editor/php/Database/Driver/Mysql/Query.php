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

namespace DataTables\Database;
if (!defined('DATATABLES')) exit();

use PDO;
use DataTables\Database\Query;
use DataTables\Database\DriverMysqlResult;


/**
 * MySQL driver for DataTables Database Query class
 *  @internal
 */
class DriverMysqlQuery extends Query {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */
	private $_stmt;



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	static function connect( $user, $pass='', $host='', $port='', $db='', $dsn='' )
	{
		if ( is_array( $user ) ) {
			$opts = $user;
			$user = $opts['user'];
			$pass = $opts['pass'];
			$port = $opts['port'];
			$host = $opts['host'];
			$db   = $opts['db'];
			$dsn  = isset( $opts['dsn'] ) ? $opts['dsn'] : '';
		}

		if ( $port !== "" ) {
			$port = "port={$port};";
		}

		try {
			$pdo = @new PDO(
				"mysql:host={$host};{$port}dbname={$db}".self::dsnPostfix( $dsn ),
				$user,
				$pass,
				array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				)
			);
		} catch (\PDOException $e) {
			// If we can't establish a DB connection then we return a DataTables
			// error.
			echo json_encode( array( 
				"sError" => "An error occurred while connecting to the database ".
					"'{$db}'. The error reported by the server was: ".$e->getMessage()
			) );
			exit(0);
		}

		return $pdo;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Protected methods
	 */

	protected function _prepare( $sql )
	{
		$this->_stmt = $this->_dbcon->prepare( $sql );

		// bind values
		for ( $i=0 ; $i<count($this->_value) ; $i++ ) {
			//echo 'Binding: {:'.$this->_field[$i] .'} as {'. $this->_value[$i]."}\n";
			$this->_stmt->bindValue(
				':'.$this->_safe_bind($this->_field[$i]),
				$this->_value[$i]
			);
		}

		// bind where values
		for ( $i=0 ; $i<count($this->_where) ; $i++ ) {
			if ( $this->_where[$i]['binder'] ) {
				//echo 'Binding where: {'.$this->_where[$i]['binder'] .'} as {'. $this->_where[$i]['value']."}\n";
				$this->_stmt->bindValue(
					$this->_safe_bind( $this->_where[$i]['binder'] ),
					$this->_where[$i]['value']
				);
			}
		}

		//file_put_contents( '/tmp/b', $sql."\n", FILE_APPEND );
	}


	protected function _exec()
	{
		try {
			$this->_stmt->execute();
		}
		catch (PDOException $e) {
			echo "An SQL error occurred: ".$e->getMessage();
			error_log( "An SQL error occurred: ".$e->getMessage() );
			return false;
		}

		return new DriverMysqlResult( $this->_dbcon, $this->_stmt );
	}
}

