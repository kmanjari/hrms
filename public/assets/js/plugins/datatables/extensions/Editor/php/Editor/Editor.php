<?php
/**
 * DataTables PHP libraries.
 *
 * PHP libraries for DataTables and DataTables Editor, utilising PHP 5.3+.
 *
 *  @author    SpryMedia
 *  @version   1.3.3
 *  @copyright 2012 SpryMedia ( http://sprymedia.co.uk )
 *  @license   http://editor.datatables.net/license DataTables Editor
 *  @link      http://editor.datatables.net
 */

namespace DataTables;
if (!defined('DATATABLES')) exit();

use
	DataTables,
	DataTables\Editor,
	DataTables\Editor\Join,
	DataTables\Editor\Field;


/**
 * DataTables Editor base class for creating editable tables.
 *
 * Editor class instances are capable of servicing all of the requests that
 * DataTables and Editor will make from the client-side - specifically:
 * -   Get data
 * -   Create new record
 * -   Edit existing record
 * -   Delete existing records
 *
 * The Editor instance is configured with information regarding the
 * database table fields that you which to make editable, and other information
 * needed to read and write to the database (table name for example!).
 *
 * This documentation is very much focused on describing the API presented
 * by these DataTables Editor classes. For a more general overview of how
 * the Editor class is used, and how to install Editor on your server, please
 * refer to the {@link http://editor.datatables.net/manual Editor manual}.
 *
 *  @example 
 *    A very basic example of using Editor to create a table with four fields.
 *    This is all that is needed on the server-side to create a editable
 *    table - the {@link process} method determines what action DataTables /
 *    Editor is requesting from the server-side and will correctly action it.
 *    <code>
 *      Editor::inst( $db, 'browsers' )
 *          ->fields(
 *              Field::inst( 'first_name' )->validator( 'Validate::required' ),
 *              Field::inst( 'last_name' )->validator( 'Validate::required' ),
 *              Field::inst( 'country' ),
 *              Field::inst( 'details' )
 *          )
 *          ->process( $_POST )
 *          ->json();
 *    </code>
 */
class Editor extends Ext {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Constructor.
	 *  @param Database $db An instance of the DataTables Database class that we can
	 *    use for the DB connection. Can be given here or with the 'db' method.
	 *    <code>
	 *      456
	 *    </code>
	 *  @param string|array $table The table name in the database to read and write
	 *    information from and to. Can be given here or with the 'table' method.
	 *  @param string $pkey Primary key column name in the table given in the $table
	 *    parameter. Can be given here or with the 'pkey' method.
	 */
	function __construct( $db=null, $table=null, $pkey=null )
	{
		// Set constructor parameters using the API - note that the get/set will
		// ignore null values if they are used (i.e. not passed in)
		$this->db( $db );
		$this->table( $table );
		$this->pkey( $pkey );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public properties
	 */

	/** @var string */
	public $version = '1.3.3';



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */

	/** @var DataTables\Database */
	private $_db = null;

	/** @var DataTables\Editor\Field[] */
	private $_fields = array();

	/** @var array */
	private $_formData;

	/** @var array */
	private $_processData;

	/** @var string */
	private $_idPrefix = 'row_';

	/** @var DataTables\Editor\Join[] */
	private $_join = array();

	/** @var string */
	private $_pkey = 'id';

	/** @var string[] */
	private $_table = array();

	/** @var array */
	private $_where = array();

	/** @var array */
	private $_leftJoin = array();

	/** @var boolean */
	private $_whereSet = false;

	/** @var array */
	private $_out = array(
		"id" => -1,
		"fieldErrors" => array(),
		"error" => "",
		"data" => array()
	);



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	/**
	 * Get the data constructed in this instance.
	 * 
	 * This will get the PHP array of data that has been constructed for the 
	 * command that has been processed by this instance. Therefore only useful after
	 * process has been called.
	 *  @return array Processed data array.
	 */
	public function data ()
	{
		return $this->_out;
	}


	/**
	 * Get / set the DB connection instance
	 *  @param Database $_ DataTable's Database class instance to use for database
	 *    connectivity. If not given, then used as a getter.
	 *  @return Database|self The Database connection instance if no parameter
	 *    is given, or self if used as a setter.
	 */
	public function db ( $_=null )
	{
		return $this->_getSet( $this->_db, $_ );
	}


	/**
	 * Get / set field instances.
	 * 
	 * The list of fields designates which columns in the table that Editor will work
	 * with (both get and set).
	 *  @param Field $_... Instances of the {@link Field} class, given as a single 
	 *    instance of {@link Field}, an array of {@link Field} instances, or multiple
	 *    {@link Field} instance parameters for the function.
	 *  @return Field[]|self Array of fields, or self if used as a setter.
	 *  @see {@link Field} for field documentation.
	 */
	public function field ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_fields, $_, true );
	}


	/**
	 * Get / set field instances.
	 * 
	 * An alias of {@link field}, for convenience.
	 *  @param Field $_... Instances of the {@link Field} class, given as a single 
	 *    instance of {@link Field}, an array of {@link Field} instances, or multiple
	 *    {@link Field} instance parameters for the function.
	 *  @return Field[]|self Array of fields, or self if used as a setter.
	 *  @see {@link Field} for field documentation.
	 */
	public function fields ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_fields, $_, true );
	}


	/**
	 * Get / set the DOM prefix.
	 *
	 * Typically primary keys are numeric and this is not a valid ID value in an
	 * HTML document - is also increases the likelihood of an ID clash if multiple
	 * tables are used on a single page. As such, a prefix is assigned to the 
	 * primary key value for each row, and this is used as the DOM ID, so Editor
	 * can track individual rows.
	 *  @param string $_ Primary key's name. If not given, then used as a getter.
	 *  @return string|self Primary key value if no parameter is given, or
	 *    self if used as a setter.
	 */
	public function idPrefix ( $_=null )
	{
		return $this->_getSet( $this->_idPrefix, $_ );
	}


	/**
	 * Get the data that is being processed by the Editor instance. This is only
	 * useful once the `process()` method has been called, and is available for
	 * use in validation and formatter methods.
	 *
	 *   @return array Data given to `process()`.
	 */
	public function inData ()
	{
		return $this->_processData;
	}


	/**
	 * Get / set join instances. Note that for the majority of use cases you
	 * will want to use the `leftJoin()` method. It is significantly easier
	 * to use if you are just doing a simple left join!
	 * 
	 * The list of Join instances that Editor will join the parent table to
	 * (i.e. the one that the {@link table} and {@link fields} methods refer to
	 * in this class instance).
	 *
	 *  @param Join $_,... Instances of the {@link Join} class, given as a
	 *    single instance of {@link Join}, an array of {@link Join} instances,
	 *    or multiple {@link Join} instance parameters for the function.
	 *  @return Join[]|self Array of joins, or self if used as a setter.
	 *  @see {@link Join} for joining documentation.
	 */
	public function join ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_join, $_, true );
	}


	/**
	 * Get the JSON for the data constructed in this instance.
	 * 
	 * Basically the same as the {@link data} method, but in this case we echo, or
	 * return the JSON string of the data.
	 *  @param boolean $print Echo the JSON string out (true, default) or return it
	 *    (false).
	 *  @return string|self self if printing the JSON, or JSON representation of 
	 *    the processed data if false is given as the first parameter.
	 */
	public function json ( $print=true )
	{
		if ( $print ) {
			echo json_encode( $this->_out );
			return $this;
		}
		return json_encode( $this->_out );
	}


	/**
	 * Add a left join condition to the Editor instance, allowing it to operate
	 * over multiple tables. Multiple `leftJoin()` calls can be made for a
	 * single Editor instance to join multiple tables.
	 *
	 * A left join is the most common type of join that is used with Editor
	 * so this method is provided to make its use very easy to configure. Its
	 * parameters are basically the same as writing an SQL left join statement,
	 * but in this case Editor will handle the create, update and remove
	 * requirements of the join for you:
	 *
	 * * Create - On create Editor will insert the data into the primary table
	 *   and then into the joined tables - selecting the required data for each
	 *   table.
	 * * Edit - On edit Editor will update the main table, and then either
	 *   update the existing rows in the joined table that match the join and
	 *   edit conditions, or insert a new row into the joined table if required.
	 * * Remove - On delete Editor will remove the main row and then loop over
	 *   each of the joined tables and remove the joined data matching the join
	 *   link from the main table.
	 *
	 * Please note that when using join tables, Editor requires that you fully
	 * qualify each field with the field's table name. SQL can result table
	 * names for ambiguous field names, but for Editor to provide its full CRUD
	 * options, the table name must also be given. For example the field
	 * `first_name` in the table `users` would be given as `users.first_name`.
	 *
	 * @param string $table Table name to do a join onto
	 * @param string $field1 Field from the parent table to use as the join link
	 * @param string $operator Join condition (`=`, '<`, etc)
	 * @param string $field2 Field from the child table to use as the join link
	 * @return self Self for chaining.
	 *
	 * @example 
	 *    Simple join:
	 *    <code>
	 *        ->field( 
	 *          Field::inst( 'users.first_name as myField' ),
	 *          Field::inst( 'users.last_name' ),
	 *          Field::inst( 'users.dept_id' ),
	 *          Field::inst( 'dept.name' )
	 *        )
	 *        ->leftJoin( 'dept', 'users.dept_id', '=', 'dept.id' )
	 *        ->process($_POST)
	 *        ->json();
	 *    </code>
	 *
	 *    This is basically the same as the following SQL statement:
	 * 
	 *    <code>
	 *      SELECT users.first_name, users.last_name, user.dept_id, dept.name
	 *      FROM users
	 *      LEFT JOIN dept ON users.dept_id = dept.id
	 *    </code>
	 */
	public function leftJoin ( $table, $field1, $operator, $field2 )
	{
		$this->_leftJoin[] = array(
			"table"    => $table,
			"field1"   => $field1,
			"field2"   => $field2,
			"operator" => $operator
		);

		return $this;
	}


	/**
	 * Get / set the table name.
	 * 
	 * The table name designated which DB table Editor will use as its data
	 * source for working with the database. Table names can be given with an
	 * alias, which can be used to simplify larger table names. The field
	 * names would also need to reflect the alias, just like an SQL query. For
	 * example: `users as a`.
	 *
	 *  @param string|array $_,... Table names given as a single string, an array of
	 *    strings or multiple string parameters for the function.
	 *  @return string[]|self Array of tables names, or self if used as a setter.
	 */
	public function table ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_table, $_, true );
	}


	/**
	 * Get / set the primary key.
	 *
	 * The primary key must be known to Editor so it will know which rows are being
	 * edited / deleted upon those actions. The default value is 'id'.
	 *  @param string $_ Primary key's name. If not given, then used as a getter.
	 *  @return string|self Primary key value if no parameter is given, or
	 *    self if used as a setter.
	 */
	public function pkey ( $_=null )
	{
		return $this->_getSet( $this->_pkey, $_ );
	}


	/**
	 * Process a request from the Editor client-side to get / set data.
	 *  @param array $data Typically $_POST or $_GET as required by what is sent by Editor
	 *  @return self
	 */
	public function process ( $data )
	{
		$this->_processData = $data;
		$this->_formData = isset($data['data']) ? $data['data'] : null;

		$this->_db->transaction();

		try {
			$this->_prepJoin();

			if ( !isset($data['action']) ) {
				/* Get data */
				$this->_out = array_merge( $this->_out, $this->_get( null, $data ) );
			}
			else if ( $data['action'] == "remove" ) {
				/* Remove rows */
				$this->_remove( $data );
			}
			else {
				/* Create or edit row */
				$valid = $this->validate( $this->_out['fieldErrors'], $data );

				// Global validation - if you want global validation - do it here
				// $this->_out['error'] = "";

				if ( $valid ) {
					if ( $data['action'] == "create" ) {
						$this->_out['row'] = $this->_insert();
					}
					else {
						$this->_out['row'] = $this->_update( $data['id'] );
					}
				}
			}

			$this->_db->commit();
		}
		catch (\Exception $e) {
			// Error feedback
			$this->_out['error'] = $e->getMessage();
			$this->_db->rollback();
		}

		// Tidy up the reply
		if ( count( $this->_out['fieldErrors'] ) === 0 ) {
			unset( $this->_out['fieldErrors'] );
		}

		if ( isset($data['action']) && count( $this->_out['data'] ) === 0 ) {
			unset( $this->_out['data'] );
		}

		if ( $this->_out['error'] === '' ) {
			unset( $this->_out['error'] );
		}

		// Not required in the Editor libraries
		unset( $this->_out['id'] );

		return $this;
	}


	/**
	 * Perform validation on a data set.
	 *
	 * Note that validation is performed on data only when the action is
	 * `create` or `edit`. Additionally, validation is performed on the _wire
	 * data_ - i.e. that which is submitted from the client, without formatting.
	 * Any formatting required by `setFormatter` is performed after the data
	 * from the client has been validated.
	 *
	 *  @param &array $errors Output array to which field error information will
	 *      be written. Each element in the array represents a field in an error
	 *      condition. These elements are themselves arrays with two properties
	 *      set; `name` and `status`.
	 *  @param array $data The format data to check
	 *  @return boolean `true` if the data is valid, `false` if not.
	 */
	public function validate ( &$errors, $data )
	{
		// Validation is only performs on create and edit
		if ( $data['action'] != "create" && $data['action'] != "edit" ) {
			return true;
		}

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];
			$validation = $field->validate( $data['data'], $this );

			if ( $validation !== true ) {
				$errors[] = array(
					"name" => $field->name(),
					"status" => $validation
				);
			}
		}

		return count( $errors ) > 0 ? false : true;
	}


	/**
	 * Where condition to add to the query used to get data from the database.
	 * 
	 * Can be used in two different ways, as where( field, value ) or as an array of
	 * conditions to use: where( array('fieldName', ...), array('value', ...) );
	 *
	 * Please be very careful when using this method! If an edit made by a user using
	 * Editor removes the row from the where condition, the result is undefined (since
	 * Editor expects the row to still be available, but the condition removes it from
	 * the result set).
	 *  @param string|string[] $key   Single field name, or an array of field names.
	 *  @param string|string[] $value Single field value, or an array of values.
	 *  @param string          $op    Condition operator: <, >, = etc
	 *  @return string[]|self Where condition array, or self if used as a setter.
	 */
	public function where ( $key=null, $value=null, $op='=' )
	{
		if ( $key === null ) {
			return $this->_where;
		}

		$this->_where[] = array(
			"key"   => $key,
			"value" => $value,
			"op"    => $op
		);

		return $this;
	}


	/**
	 * Get / set if the WHERE conditions should be included in the create and
	 * edit actions.
	 * 
	 * This means that the fields which have been used as part of the 'get'
	 * WHERE condition (using the `where()` method) will be set as the values
	 * given. *Note* The value given for the where operation is what will be
	 * set in the database, regardless of the condition operator given (the
	 * optional third parameter for the `where()` method).
	 *
	 * This is default false (i.e. they are not included).
	 *
	 *  @param boolean $_ Include (`true`), or not (`false`)
	 *  @return boolean Current value
	 */
	public function whereSet ( $_=null )
	{
		return $this->_getSet( $this->_whereSet, $_ );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Get an array of objects from the database to be given to DataTables as a
	 * result of an sAjaxSource request, such that DataTables can display the information
	 * from the DB in the table.
	 *  @param integer $id Primary key value to get an individual row (after create or
	 *    update operations). Gets the full set if not given.
	 *  @param array $http HTTP parameters from GET or POST request (so we can service
	 *    server-side processing requests from DataTables).
	 *  @private
	 */
	private function _get( $id=null, $http=null )
	{
		$query = $this->_db
			->query('select')
			->table( $this->_table )
			->get( $this->_pkey )
			->get( $this->_fields('get') );

		$this->_get_where( $query );
		$this->_left_join( $query );
		$ssp = $this->_ssp_query( $query, $http );

		if ( $id !== null ) {
			$query->where( $this->_pkey, $id );
		}

		$res = $query->exec();
		if ( ! $res ) {
			throw new \Exception('Error executing SQL for data get');
		}

		$out = array();
		while ( $row=$res->fetch() ) {
			$inner = array();
			$inner['DT_RowId'] = $this->_idPrefix . $row[ $this->_pkey ];

			for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
				$field = $this->_fields[$i];

				if ( $field->apply('get') ) {
					$field->write( $inner, $row );
				}
			}

			$out[] = $inner;
		}

		// Row based "joins"
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->data( $this->_db, $this->table(), $this->pkey(),
				$this->idPrefix(), $out
			);
		}

		return array_merge( array('data'=>$out), $ssp );
	}


	/**
	 * Insert a new row in the database
	 *  @private
	 */
	private function _insert( )
	{
		// Insert the new row
		$id = $this->_insert_or_update( null );

		// Was the primary key sent? Unusual, but it is possible
		if ( isset( $this->_formData[ $this->_pkey ] ) ) {
			$id = $this->_formData[ $this->_pkey ];
		}

		// Join tables
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->create( $this->_db, $id, $this->_formData );
		}

		// Full data set for the created
		$row = $this->_get( $id );
		return count( $row['data'] ) > 0 ?
			$row['data'][0] :
			null;
	}


	/**
	 * Update a row in the database
	 *  @param string $id The DOM ID for the row that is being edited.
	 *  @private
	 */
	private function _update( $id )
	{
		$id = str_replace( $this->_idPrefix, '', $id );

		// Update or insert the rows for the parent table and the left joined
		// tables
		$this->_insert_or_update( $id );

		// And the join tables
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->update( $this->_db, $id, $this->_formData );
		}

		// Was the primary key altered as part of the edit? Unusual, but it is
		// possible
		$getId = isset( $this->_formData[ $this->_pkey ] ) ?
			$this->_formData[ $this->_pkey ] :
			$id;

		// Full data set for the modified row
		$row = $this->_get( $getId );
		return count( $row['data'] ) > 0 ?
			$row['data'][0] :
			null;
	}


	/**
	 * Delete one or more rows from the database
	 *  @private
	 */
	private function _remove( $data )
	{
		$inIds = is_array( $data['id'] ) ?
			$data['id'] :
			array( $data['id'] );

		if ( count( $inIds ) === 0 ) {
			throw new \Exception('No ids submitted for the delete');
		}

		// Strip the ID prefix that the client-side sends back
		for ( $i=0 ; $i<count($inIds) ; $i++ ) {
			$ids[] = str_replace( $this->_idPrefix, "", $inIds[$i] );
		}

		// Remove from the primary tables
		for ( $i=0, $ien=count($this->_table) ; $i<$ien ; $i++ ) {
			$this->_remove_table( $this->_table[$i], $ids );
		}

		// Remove from the left join tables
		for ( $i=0, $ien=count($this->_leftJoin) ; $i<$ien ; $i++ ) {
			$join = $this->_leftJoin[$i];
			$table = $this->_alias( $join['table'], 'orig' );

			// which side of the join refers to the parent table?
			if ( strpos( $join['field1'], $join['table'] ) === 0 ) {
				$parentLink = $join['field2'];
				$childLink = $join['field1'];
			}
			else {
				$parentLink = $join['field1'];
				$childLink = $join['field2'];
			}

			// Only delete on the primary key, since that is what the ids refer
			// to - otherwise we'd be deleting random data!
			if ( $parentLink === $this->_pkey ) {
				$this->_remove_table( $this->_leftJoin[$i]['table'], $ids, $childLink );
			}
		}

		// And from the join tables
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->remove( $this->_db, $ids );
		}
	}
	

	/**
	 * Create an array of the DB fields to use for a get / set operation.
	 *  @param string $direction Direction: 'get' or 'set'.
	 *  @return array List of fields
	 *  @private
	 */
	private function _fields ( $direction )
	{
		$fields = array();

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];

			if ( $field->apply( $direction, $this->_formData ) ) {
				$fields[] = $field->dbField();
			}
		}

		return $fields;
	}


	/*  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *
	 * Server-side processing methods
	 */

	/**
	 * When server-side processing is being used, modify the query with // the
     * required extra conditions
	 *
	 *  @param Query $query Query instance to apply the SSP commands to
	 *  @return array Server-side processing information array
	 *  @private
	 */
	private function _ssp_query ( $query, $http )
	{
		$ssp = array();
		
		if ( ! isset( $http['draw'] ) ) {
			return array();
		}

		// Add the server-side processing conditions
		$this->_ssp_limit( $query, $http );
		$this->_ssp_sort( $query, $http );
		$this->_ssp_filter( $query, $http );

		// Get the number of rows in the result set
		$ssp_set_count = $this->_db
			->query('select')
			->table( $this->_table )
			->get( 'COUNT('.$this->_pkey.') as cnt' );
		$this->_get_where( $ssp_set_count );
		$this->_ssp_filter( $ssp_set_count, $http );
		$this->_left_join( $ssp_set_count );
		$ssp_set_count = $ssp_set_count->exec()->fetch();

		// Get the number of rows in the full set
		$ssp_full_count = $this->_db
			->query('select')
			->table( $this->_table )
			->get( 'COUNT('.$this->_pkey.') as cnt' );
		$this->_get_where( $ssp_full_count );
		if ( count( $this->_where ) ) { // only needed if there is a where condition
			$this->_left_join( $ssp_full_count );
		}
		$ssp_full_count = $ssp_full_count->exec()->fetch();

		return array(
			"draw" => intval( $http['draw'] ),
			"recordsTotal" => $ssp_full_count['cnt'],
			"recordsFiltered" => $ssp_set_count['cnt']
		);
	}


	/**
	 * Convert a column index to a database field name - used for server-side
	 * processing requests.
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @param int $index Index in the DataTables' submitted data
	 *  @returns string DB field name
	 *  @private // It is actually public for PHP 5.3 compatibility with a closure
	 */
	public function _ssp_field( $http, $index )
	{
		$name = $http['columns'][$index]['data'];
		$field = $this->_find_field( $name, 'name' );

		if ( ! $field ) {
			throw new \Exception('Unknown field: '.$name .' (index '.$index.')');
		}

		return $field->dbField();
	}


	/**
	 * Sorting requirements to a server-side processing query.
	 *  @param Query $query Query instance to apply sorting to
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @private
	 */
	private function _ssp_sort ( $query, $http )
	{
		for ( $i=0 ; $i<count($http['order']) ; $i++ ) {
			$order = $http['order'][$i];

			$query->order(
				$this->_ssp_field( $http, $order['column'] ) .' '.
				($order['dir']==='asc' ? 'asc' : 'desc')
			);
		}
	}


	/**
	 * Add DataTables' 'where' condition to a server-side processing query. This
	 * works for both global and individual column filtering.
	 *  @param Query $query Query instance to apply the WHERE conditions to
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @private
	 */
	private function _ssp_filter ( $query, $http )
	{
		$that = $this;

		// Global filter
		$fields = $this->_fields;

		// Global search, add a ( ... or ... ) set of filters for each column
		// in the table (not the fields, just the columns submitted)
		if ( $http['search']['value'] ) {
			$query->where( function ($q) use (&$that, &$fields, $http) {
				for ( $i=0 ; $i<count($http['columns']) ; $i++ ) {
					if ( $http['columns'][$i]['searchable'] == 'true' ) {
						$field = $that->_ssp_field( $http, $i );

						$q->or_where( $field, '%'.$http['search']['value'].'%', 'like' );
					}
				}
			} );
		}

		// Column filters
		for ( $i=0, $ien=count($http['columns']) ; $i<$ien ; $i++ ) {
			$column = $http['columns'][$i];
			$search = $column['search']['value'];

			if ( $search && $column['searchable'] == 'true' ) {
				$query->where( $this->_ssp_field( $http, $i ), '%'.$search.'%', 'like' );
			}
		}
	}


	/**
	 * Add a limit / offset to a server-side processing query
	 *  @param Query $query Query instance to apply the offset / limit to
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @private
	 */
	private function _ssp_limit ( $query, $http )
	{
		if ( $http['start'] != -1 ) { // -1 is 'show all' in DataTables
			$query
				->offset( $http['start'] )
				->limit( $http['length'] );
		}
	}


	/*  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *
	 * Internal helper methods
	 */

	/**
	 * Add left join commands for the instance to a query.
	 *
	 *  @param Query $query Query instance to apply the joins to
	 *  @private
	 */
	private function _left_join ( $query )
	{
		if ( count($this->_leftJoin) ) {
			for ( $i=0, $ien=count($this->_leftJoin) ; $i<$ien ; $i++ ) {
				$join = $this->_leftJoin[$i];

				$query->join( $join['table'], $join['field1'].' '.$join['operator'].' '.$join['field2'], 'LEFT' );
			}
		}
	}


	/**
	 * Add local WHERE condition to query
	 *  @param Query $query Query instance to apply the WHERE conditions ti
	 *  @private
	 */
	private function _get_where ( $query )
	{
		for ( $i=0 ; $i<count($this->_where) ; $i++ ) {
			$query->where(
				$this->_where[$i]['key'],
				$this->_where[$i]['value'],
				$this->_where[$i]['op']
			);
		}
	}


	/**
	 * Get a field instance from a known field name
	 *
	 *  @param string $name Field name
	 *  @return Field Field instance
	 *  @private
	 */
	private function _find_field ( $name, $type )
	{
		for ( $i=0, $ien=count($this->_fields) ; $i<$ien ; $i++ ) {
			$field = $this->_fields[ $i ];

			if ( $type === 'name' && $field->name() === $name ) {
				return $field;
			}
			else if ( $type === 'db' && $field->dbField() === $name ) {
				return $field;
			}
		}

		return null;
	}


	/**
	 * Get the table name from an SQL field name. Will throw an error if there
	 * is no table name.
	 *
	 *  @param string $name SQL field name to check.
	 *  @private
	 */
	private function _table_part ( $name )
	{
		if ( strpos( $name, '.' ) === false ) {
			throw new \Exception( 'Table part of the field '.$name.' was not found.'.
				' In Editor instances that use a join, all fields must have the '.
				' database table set explicitly. For example the field `'.$field->dbField().'`'.
				' might be: `'.$this->_alias( $this->_table[0], 'orig' ).'.'.$field->dbField().'`'
			);
		}
	}


	/**
	 * Insert or update a row for all main tables and left joined tables.
	 *
	 *  @param int $id ID to use to condition the update. If null is given, the
	 *      first query performed is an insert and the inserted id used as the
	 *      value should there be any subsequent tables to operate on.
	 *  @return Database.Result Result from the query or null if no query
	 *      performed.
	 *  @private
	 */
	private function _insert_or_update ( $id )
	{
		// Loop over all tables in _table, doing the insert or update as needed
		for ( $i=0, $ien=count( $this->_table ) ; $i<$ien ; $i++ ) {
			$res = $this->_insert_or_update_table(
				$this->_table[$i],
				$id === null ?
					null :
					array($this->_pkey => $id)
			);

			// If we don't have an id yet, then the first insert will return
			// the id we want
			if ( $id === null ) {
				$id = $res->insertId();
			}
		}

		// And for the left join tables as well
		for ( $i=0, $ien=count( $this->_leftJoin ) ; $i<$ien ; $i++ ) {
			$join = $this->_leftJoin[$i];

			// which side of the join refers to the parent table?
			$joinTable = $this->_alias( $join['table'], 'alias' );
			$tablePart = $this->_part( $join['field1'] );

			if ( $this->_part( $join['field1'], 'db' ) ) {
				$tablePart = $this->_part( $join['field1'], 'db' ).'.'.$tablePart;
			}

			if ( $tablePart === $joinTable ) {
				$parentLink = $join['field2'];
				$childLink = $join['field1'];
			}
			else {
				$parentLink = $join['field1'];
				$childLink = $join['field2'];
			}

			if ( $parentLink === $this->_pkey ) {
				$where = array( $childLink => $id );
			}
			else {
				$field = $this->_find_field( $parentLink, 'db' );
				if ( ! $field ) {
					// The parent field wasn't included in the field list, so
					// nothing can be done with it
					continue;
				}

				$where = array( $childLink => $field->val('set', $this->_formData) );
			}

			$this->_insert_or_update_table( $join['table'], $where );
		}

		return $id;
	}


	/**
	 * Insert or update a row in a single database table, based on the data
	 * given and the fields configured for the instance.
	 *
	 * The function will find the fields which are required for this specific
	 * table, based on the names of fields and use only the appropriate data for
	 * this table. Therefore the full submitted data set can be passed in.
	 *
	 *  @param string $table Database table name to use (can include an alias)
	 *  @param array $where Update condition
	 *  @return Database.Result Result from the query or null if no query
	 *      performed.
	 *  @private
	 */
	private function _insert_or_update_table ( $table, $where=null )
	{
		$set = array();
		$tableName = $this->_alias( $table, 'orig' );
		$tableAlias = $this->_alias( $table, 'alias' );

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];
			$tablePart = $this->_part( $field->dbField() );

			if ( $this->_part( $field->dbField(), 'db' ) ) {
				$tablePart = $this->_part( $field->dbField(), 'db' ).'.'.$tablePart;
			}

			// Does this field apply to this table (only check when a join is
			// being used)
			if ( count($this->_leftJoin) && $tablePart !== $tableAlias ) {
				continue;
			}

			// Check if this field should be set, based on options and
			// submitted data
			if ( ! $field->apply( 'set', $this->_formData ) ) {
				continue;
			}

			// Some db's (specifically postgres) don't like having the table
			// name prefixing the column name. TODO it might be nicer to have
			// the db layer abstract this out?
			$fieldPart = $this->_part( $field->dbField(), 'field' );
			$set[ $fieldPart ] = $field->val('set', $this->_formData);

			// Add where fields if setting where values and required for this
			// table
			if ( $this->_whereSet ) {
				for ( $j=0, $jen=count($this->_where) ; $j<$jen ; $j++ ) {
					$cond = $this->_where[$j];

					if ( $tableAlias === $this->_table_part( $cond['key'] ) && ! isset( $set[ $cond['key'] ] ) ) {
						$set[ $cond['key'] ] = $cond['value'];
					}
				}
			}
		}

		// If nothing to do, then do nothing!
		if ( ! count( $set ) ) {
			return null;
		}

		// Insert or update
		if ( $where === null ) {
			return $this->_db->insert( $this->_table, $set );
		}
		else {
			return $this->_db->push( $table, $set, $where );
		}
	}


	/**
	 * Delete one or more rows from the database for an individual table
	 *
	 *  @param string $table Database table name to use
	 *  @param array $ids Array of ids to remove
	 *  @param string $pkey Database column name to match the ids on for the
	 *    delete condition. If not given the instance's base primary key is
	 *    used.
	 *  @private
	 */
	function _remove_table ( $table, $ids, $pkey=null )
	{
		if ( $pkey === null ) {
			$pkey = $this->_pkey;
		}

		$stmt = $this->_db
			->query( 'delete' )
			->table( $table )
			->or_where( $pkey, $ids )
			->exec();
	}


	/**
	 * Check the validity of the set options if  we are doing a join, since
	 * there are some conditions for this state. Will throw an error if not
	 * valid.
	 *
	 *  @private
	 */
	private function _prepJoin ()
	{
		if ( count( $this->_leftJoin ) === 0 ) {
			return;
		}

		// Check if the primary key has a table identifier - if not - add one
		if ( strpos( $this->_pkey, '.' ) === false ) {
			$this->_pkey = $this->_alias( $this->_table[0], 'alias' ).'.'.$this->_pkey;
		}

		// Check that all fields have a table selector, otherwise, we'd need to
		// know the structure of the tables, to know which fields belong in
		// which. This extra requirement on the fields removes that
		for ( $i=0, $ien=count($this->_fields) ; $i<$ien ; $i++ ) {
			$field = $this->_fields[$i];

			$this->_table_part( $field->dbField() ); // will throw an error if no table part
		}
	}


	/**
	 * Get one side or the other of an aliased SQL field name.
	 *
	 *  @param string $name SQL field
	 *  @param string $type Which part to get: `alias` (default) or `orig`.
	 *  @private
	 */
	private function _alias ( $name, $type='alias' )
	{
		if ( strpos( $name, ' as ' ) === false ) {
			return $name;
		}

		$a = explode( ' as ', $name );
		return $type === 'alias' ?
			$a[1] :
			$a[0];
	}


	/**
	 * Get part of an SQL field definition regardless of how deeply defined it
	 * is
	 *
	 *  @param string $name SQL field
	 *  @param string $type Which part to get: `table` (default) or `db` or
	 *      `column`
	 *  @private
	 */
	private function _part ( $name, $type='table' )
	{
		$db = null;
		$table = null;
		$column = null;

		if ( strpos( $name, '.' ) !== false ) {
			$a = explode( '.', $name );

			if ( count($a) === 3 ) {
				$db = $a[0];
				$table = $a[1];
				$column = $a[2];
			}
			else if ( count($a) === 2 ) {
				$table = $a[0];
				$column = $a[1];
			}
		}
		else {
			$column = $name;
		}

		if ( $type === 'db' ) {
			return $db;
		}
		else if ( $type === 'table' ) {
			return $table;
		}
		return $column;
	}
}

