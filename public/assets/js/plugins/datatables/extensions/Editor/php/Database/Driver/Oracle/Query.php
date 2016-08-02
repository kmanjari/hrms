<?php
/**
 * Oracle database driver for DataTables libraries. Please note that this
 * uses the Oracle PDO driver, not the oci8_*() methods.
 *
 * This is a *beta* driver.
 *
 * @author    SpryMedia
 * @copyright 2014 SpryMedia ( http://sprymedia.co.uk )
 * @license   http://editor.datatables.net/license DataTables Editor
 * @link      http://editor.datatables.net
 */

namespace DataTables\Database;
if ( ! defined( 'DATATABLES' ) ) {
	exit();
}

use PDO;


/**
 * MySQL driver for DataTables Database Query class
 * @internal
 */
class DriverOracleQuery extends Query {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */
	protected $_identifier_limiter = '';
	protected $_field_quote = '"';
	private $_stmt;

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	static function connect( $user, $pass = '', $host = '', $port = '', $db = '', $dsn = '' ) {
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
			$port = ":{$port}";
		}

		try {
			$pdo = @new PDO(
				"oci:dbname=//{$host}{$port}/{$db}" . self::dsnPostfix( $dsn ),
				$user,
				$pass,
				array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				)
			);
		} catch ( \PDOException $e ) {
			// If we can't establish a DB connection then we return a DataTables
			// error.
			echo json_encode( array(
				"sError" => "An error occurred while connecting to the database " .
				            "'{$db}'. The error reported by the server was: " . $e->getMessage()
			) );
			exit( 0 );
		}

		// Conform to ISO standards
		$stmt = $pdo->prepare( "ALTER SESSION SET NLS_DATE_FORMAT='YYYY-MM-DD HH24:MI:SS'" );
		$stmt->execute();

		return $pdo;
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Protected methods
	 */

	protected function _prepare( $sql ) {
		$this->_stmt = $this->_dbcon->prepare( $sql );

		// bind values
		for ( $i = 0; $i < count( $this->_value ); $i ++ ) {
			//echo 'Binding: {:'.$this->_field[$i] .'} as {'. $this->_value[$i]."}\n";
			$this->_stmt->bindValue( ':' . $this->_field[ $i ], $this->_value[ $i ] );
		}

		// bind where values
		for ( $i = 0; $i < count( $this->_where ); $i ++ ) {
			if ( $this->_where[ $i ]['binder'] ) {
				//echo 'Binding where: {'.$this->_where[$i]['binder'] .'} as {'. $this->_where[$i]['value']."}\n";
				$this->_stmt->bindValue( $this->_where[ $i ]['binder'], $this->_where[ $i ]['value'] );
			}
		}

		//if ( $this->_type === 'insert') {
		//	echo $sql."\n";
		//}
	}


	protected function _exec() {
		try {
			$this->_stmt->execute();
		} catch ( PDOException $e ) {
			echo "An SQL error occurred: " . $e->getMessage();
			error_log( "An SQL error occurred: " . $e->getMessage() );

			return false;
		}

		return new DriverOracleResult( $this->_dbcon, $this->_stmt );
	}


	// Oracle required table quoting to be done with double quotes
	protected function _build_table() {
		return ' "' . implode( '", "', $this->_table ) . '" ';
	}
}

