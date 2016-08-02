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

namespace DataTables\Editor;
if (!defined('DATATABLES')) exit();

use
	DataTables,
	DataTables\Editor,
	DataTables\Editor\Join,
	DataTables\Editor\Field;


/**
 * Join table class for DataTables Editor.
 *
 * The Join class can be used with {@link Editor::join} to allow Editor to
 * obtain joined information from the database.
 *
 * For an overview of how Join tables work, please refer to the 
 * {@link http://editor.datatables.net/manual/php/joins Editor manual} as it is
 * useful to understand how this class represents the links between tables, 
 * before fully getting to grips with it's API.
 *
 * Please note that the {@link Join} class is not available in the trial
 * version of Editor, but is included, with full source, in the licensed
 * download package.
 *
 *  @example
 *    Join the parent table (the one specified in the {@link Editor::table}
 *    method) with the table *access*, with a link table *user__access*, which
 *    allows multiple properties to be found for each row in the parent table.
 *    <code>
 *      Join::inst( 'access', 'array' )
 *          ->join(
 *              array( 'id', 'user_id' ),
 *              array( 'id', 'access_id' ),
 *              'user_access'
 *          )
 *          ->field(
 *              Field::inst( 'id' )->validator( 'Validate::required' ),
 *              Field::inst( 'name' )
 *          )
 *    </code>
 *
 *  @example
 *    Single row join - here we join the parent table with a single row in
 *    the child table, without an intermediate link table. In this case the
 *    child table is called *extra* and the two fields give the columns that
 *    Editor will read from that table.
 *    <code>
 *        Join::inst( 'extra', 'object' )
 *            ->join( 'id', 'user_id' )
 *            ->field(
 *                Field::inst( 'comments' ),
 *                Field::inst( 'review' )
 *            )
 *    </code>
 */
class Join extends DataTables\Ext {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Join instance constructor.
	 *  @param string $table Table name to get the joined data from.
	 *  @param string $type Work with a single result ('object') or an array of 
	 *    results ('array') for the join.
	 */
	function __construct( $table=null, $type='object' )
	{
		$this->table( $table );
		$this->type( $type );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */

	/** @var DataTables\Editor\Field[] */
	private $_fields = array();

	/** @var array */
	private $_join = array(
		"parent" => null,
		"child" => null,
		"table" => null
	);

	/** @var string */
	private $_table = null;

	/** @var string */
	private $_type = null;

	/** @var string */
	private $_name = null;

	/** @var boolean */
	private $_get = true;

	/** @var boolean */
	private $_set = true;

	/** @var string */
	private $_aliasParentTable = null;

	/** @var array */
	private $_where = array();

	/** @var boolean */
	private $_whereSet = false;


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */
	
	/**
	 * Get / set parent table alias.
	 * 
	 * When working with a self referencing table (i.e. a column in the table contains
	 * a primary key value from its own table) it can be useful to set an alias on the
	 * parent table's name, allowing a self referencing Join. For example:
	 *   <code>
	 *   SELECT p2.publisher 
	 *   FROM   publisher as p2
	 *   JOIN   publisher on (publisher.idPublisher = p2.idPublisher)
	 *   <code>
	 * Where, in this case, `publisher` is the table that is used by the Editor instance,
	 * and you want to use `Join` to link back to the table (resolving a name for example).
	 * This method allows that alias to be set. Fields can then use standard SQL notation
	 * to select a field, for example `p2.publisher` or `publisher.publisher`.
	 *  @param string $_ Table alias to use
	 *  @return string|self Table alias set (which is null by default), or self if used as
	 *    a setter.
	 */
	public function aliasParentTable ( $_=null )
	{
		return $this->_getSet( $this->_aliasParentTable, $_ );
	}


	/**
	 * Get / set field instances.
	 * 
	 * The list of fields designates which columns in the table that will be read
	 * from the joined table.
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
	 * Get / set get attribute.
	 * 
	 * When set to false no read operations will occur on the join tables.
	 *  @param boolean $_ Value
	 *  @return boolean|self Name
	 */
	public function get ( $_=null )
	{
		return $this->_getSet( $this->_get, $_ );
	}


	/**
	 * Get / set join properties.
	 *
	 * Define how the SQL will be performed, on what columns. There are basically
	 * two types of join that are supported by Editor here, a direct foreign key
	 * reference in the join table to the parent table's primary key, or a link 
	 * table that contains just primary keys for the parent and child tables (this
	 * approach is usually used with a {@link type} of 'array' since you can often
	 * have multiple links between the two tables, while a direct foreign key
	 * reference will typically use a type of 'object' (i.e. a single entry).
	 *  @param string|string[] $parent Parent table's primary key names. If
	 *    used with a link table (i.e. third parameter to this method is given, then
	 *    an array should be used, with the first element being the pkey's name in
	 *    the parent table, and the second element being the key's name in the link
	 *    table.
	 *  @param string|string[] $child Child table's primary key names. If
	 *    used with a link table (i.e. third parameter to this method is given, then
	 *    an array should be used, with the first element being the pkey's name in
	 *    the child table, and the second element being the key's name in the link
	 *    table.
	 *  @param {string} $table Join table name, if using a link table
	 *
	 *  @example
	 *    // Using a link table
	 *    Join::inst( 'access', 'array' )
	 *      ->join(
	 *        array( 'id', 'user_id' ),
	 *        array( 'id', 'access_id' ),
	 *        'user_access'
	 *      )
	 *
	 *  @example
	 *    // Using a direct reference (no link table)
	 *    Join::inst( 'extra', 'object' )
	 *      ->join( 'id', 'user_id' )
	 */
	public function join ( $parent=null, $child=null, $table=null )
	{
		if ( $parent === null && $child === null ) {
			return $this->_join();
		}

		$this->_join['parent'] = $parent;
		$this->_join['child'] = $child;
		$this->_join['table'] = $table;
		return $this;
	}


	/**
	 * Get / set name.
	 * 
	 * The `name` of the Join is the JSON property key that is used when 
	 * 'getting' the data, and the HTTP property key (in a JSON style) when
	 * 'setting' data. Typically the name of the db table will be used here,
	 * but this method allows that to be overridden.
	 *  @param string $_ Field name
	 *  @return String|self Name
	 */
	public function name ( $_=null )
	{
		return $this->_getSet( $this->_name, $_ );
	}


	/**
	 * Get / set set attribute.
	 * 
	 * When set to false no write operations will occur on the join tables.
	 * This can be useful when you want to display information which is joined,
	 * but want to only perform write operations on the parent table.
	 *  @param boolean $_ Value
	 *  @return boolean|self Name
	 */
	public function set ( $_=null )
	{
		return $this->_getSet( $this->_set, $_ );
	}


	/**
	 * Get / set join table name.
	 *
	 * Please note that this will also set the {@link name} used by the Join
	 * as well. This is for convenience as the JSON output / HTTP input will
	 * typically use the same name as the database name. If you want to set a
	 * custom name, the {@link name} method must be called ***after*** this one.
	 *  @param string $_ Name of the table to read the join data from
	 *  @return String|self Name of the join table, or self if used as a setter.
	 */
	public function table ( $_=null )
	{
		if ( $_ !== null ) {
			$this->_name = $_;
		}
		return $this->_getSet( $this->_table, $_ );
	}


	/**
	 * Get / set the join type.
	 * 
	 * The join type allows the data that is returned from the join to be given
	 * as an array (i.e. working with multiple possibly results for each record from
	 * the parent table), or as an object (i.e. working which one and only one result
	 * for each record form the parent table).
	 *  @param string $_ Join type ('object') or an array of 
	 *    results ('array') for the join.
	 *  @return String|self Join type, or self if used as a setter.
	 */
	public function type ( $_=null )
	{
		return $this->_getSet( $this->_type, $_ );
	}


	/**
	 * Where condition to add to the query used to get data from the database.
	 * Note that this is applied to the child table.
	 * 
	 * Can be used in two different ways, as where( field, value ) or as an
	 * array of conditions to use: where( array('fieldName', ...),
	 * array('value', ...) );
	 *
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
	 * given.
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
	 * Internal methods
	 */

	/**
	 * Get data
	 *  @param Database $db Database reference to use
	 *  @param array $dteTable Host table from the Editor class, only the first is used
	 *  @param string $pkey Host table primary key
	 *  @param string $idPrefix DOM id prefix
	 *  @param string[] $data Data from the parent table's get and were we need
	 *    to add out output.
	 *  @internal
	 */
	public function data( $db, $dteTable, $pkey, $idPrefix, &$data )
	{
		if ( ! $this->_get ) {
			return;
		}

		$dteTable = $dteTable[0];
		$dteTableAlias = $this->_aliasParentTable === null ? $dteTable : $this->_aliasParentTable;

		$joinField = isset($this->_join['table']) ? $this->_join['parent'][0] : $this->_join['parent'];
		$pkeyIsJoin = $pkey === $joinField || $pkey === $dteTable.'.'.$joinField;

		// When doing a self join we need to use the parent table's name for the primary key. Otherwise
		// we want the aliased parent table's name!
		$pkeyTable = $this->_table===$dteTable ? $dteTable : $dteTableAlias;

		// Sanity check that table selector fields are read only, and have an name without
		// a dot (for DataTables mData to be able to read it)
		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];

			if ( strpos( $field->dbField() , "." ) !== false ) {
				if ( $field->set() && $this->_set ) {
					echo json_encode( array(
						"sError" => "Table selected fields (i.e. '{table}.{column}') in `Join` ".
							"must be read only. Use `set(false)` for the field to disable writing."
					) );
					exit(0);
				}

				if ( strpos( $field->name() , "." ) !== false ) {
					echo json_encode( array(
						"sError" => "Table selected fields (i.e. '{table}.{column}') in `Join` ".
							"must have a name alias which does not contain a period ('.'). Use ".
							"name('---') to set a name for the field"
					) );
					exit(0);
				}
			}
		}

		// Set up the JOIN query
		$stmt = $db
			->query( 'select' )
			->get( $pkeyTable.'.'.$joinField.' as _dte_pkey' )
			->get( $this->_fields('get') )
			->table( $dteTable .' as '. $dteTableAlias );

		for ( $i=0 ; $i<count($this->_where) ; $i++ ) {
			$stmt->where(
				$this->_where[$i]['key'],
				$this->_where[$i]['value'],
				$this->_where[$i]['op']
			);
		}

		if ( isset($this->_join['table']) ) {
			// Working with a link table
			$stmt
				->join(
					$this->_join['table'],
					$dteTableAlias.'.'.$this->_join['parent'][0] .' = '. $this->_join['table'].'.'.$this->_join['parent'][1]
				)
				->join(
					$this->_table,
					$this->_table.'.'.$this->_join['child'][0] .' = '. $this->_join['table'].'.'.$this->_join['child'][1]
				);
		}
		else {
			// No link table in the middle
			$stmt
				->join(
					$this->_table,
					$this->_table.'.'.$this->_join['child'] .' = '. $dteTableAlias.'.'.$this->_join['parent']
				);
		}
		
		$res = $stmt->exec();
		if ( ! $res ) {
			return;
		}

		// Map to primary key for fast lookup
		$join = array();
		while ( $row=$res->fetch() ) {
			$inner = array();

			for ( $j=0 ; $j<count($this->_fields) ; $j++ ) {
				$field = $this->_fields[$j];
				if ( $field->apply('get') ) {
					$inner[ $field->name() ] = $field->val('get', $row);
				}
			}

			if ( $this->_type === 'object' ) {
				$join[ $row['_dte_pkey'] ] = $inner;
			}
			else {
				if ( !isset( $join[ $row['_dte_pkey'] ] ) ) {
					$join[ $row['_dte_pkey'] ] = array();
				}
				$join[ $row['_dte_pkey'] ][] = $inner;
			}
		}

		// Check that the joining field is available
		// The joining key can come from the Editor instance's primary key, or
		// any other field. If the instance's pkey, then we've got that in the DT_RowId
		// parameter, so we can use that. Otherwise, the key must be in the field list.
		if ( !$pkeyIsJoin && count($data) > 0 && !isset($data[0][ $joinField ]) ) {
			echo json_encode( array(
				"sError" => "Join was performed on the field '{$joinField}' which was not "
					."included in the Editor field list. The join field must be included "
					."as a regular field in the Editor instance."
			) );
			exit(0);
		}

		// Loop over the data and do a join based on the data available
		for ( $i=0 ; $i<count($data) ; $i++ ) {
			$rowPKey = $pkeyIsJoin ? 
				str_replace( $idPrefix, '', $data[$i]['DT_RowId'] ) :
				$data[$i][ $joinField ];

			if ( isset( $join[$rowPKey] ) ) {
				$data[$i][ $this->_name ] = $join[$rowPKey];
			}
			else {
				$data[$i][ $this->_name ] = ($this->_type === 'object') ?
					(object)array() : array();
			}
		}
	}


	/**
	 * Create a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @internal
	 */
	public function create ( $db, $parentId, $data )
	{
		if ( ! $this->_set || ! isset($data[$this->_name]) ) {
			return;
		}
		
		if ( $this->_type === 'object' ) {
			$this->_insert( $db, $parentId, $data[$this->_name] );
		}
		else {
			for ( $i=0 ; $i<count($data[$this->_name]) ; $i++ ) {
				$this->_insert( $db, $parentId, $data[$this->_name][$i] );
			}
		}
	}


	/**
	 * Update a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @internal
	 */
	public function update ( $db, $parentId, $data )
	{
		if ( ! $this->_set ) {
			return;
		}
		
		if ( $this->_type === 'object' ) {
			// update or insert
			$this->_update_row( $db, $parentId, $data[$this->_name] );
		}
		else {
			// WARNING - this will remove rows and then readd them. Any
			// data not in the field list WILL BE LOST
			// todo - is there a better way of doing this?
			$this->remove( $db, array($parentId) );
			$this->create( $db, $parentId, $data );
		}
	}


	/**
	 * Delete rows
	 *  @param Database $db Database reference to use
	 *  @param int[] $ids Parent row IDs to delete
	 *  @internal
	 */
	public function remove ( $db, $ids )
	{
		if ( ! $this->_set ) {
			return;
		}
		
		if ( isset($this->_join['table']) ) {
			$stmt = $db
				->query( 'delete' )
				->table( $this->_join['table'] )
				->or_where( $this->_join['parent'][1], $ids )
				->exec();
		}
		else {
			$stmt = $db
				->query( 'delete' )
				->table( $this->_table )
				->where_group( true )
				->or_where( $this->_join['child'], $ids )
				->where_group( false );

			for ( $i=0, $ien=count($this->_where) ; $i<$ien ; $i++ ) {
				$stmt->where( $this->_where[$i]['key'], $this->_where[$i]['value'] );
			}

			$stmt->exec();
		}
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Create a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @private
	 */
	private function _insert( $db, $parentId, $data )
	{
		if ( isset($this->_join['table']) ) {
			// Insert keys into the join table
			$stmt = $db
				->query('insert')
				->table( $this->_join['table'] )
				->set( $this->_join['parent'][1], $parentId )
				->set( $this->_join['child'][1], $data[$this->_join['child'][0]] )
				->exec();
		}
		else {
			// Insert values into the target table
			$stmt = $db
				->query('insert')
				->table( $this->_table )
				->set( $this->_join['child'], $parentId );

			for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
				$field = $this->_fields[$i];

				if ( $field->apply( 'set', $data ) ) {
					$stmt->set( $field->dbField(), $field->val('set', $data) );
				}
			}

			// If the where condition variables should also be added to the database
			if ( $this->_whereSet ) {
				for ( $i=0, $ien=count($this->_where) ; $i<$ien ; $i++ ) {
					$stmt->set( $this->_where[$i]['key'], $this->_where[$i]['value'] );
				}
			}

			$stmt->exec(); 
		}
	}


	/**
	 * Update a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @private
	 */
	private function _update_row ( $db, $parentId, $data )
	{
		if ( isset($this->_join['table']) ) {
			// Got a link table, just insert the pkey references
			$db->push(
				$this->_join['table'],
				array(
					$this->_join['parent'][1] => $parentId,
					$this->_join['child'][1]  => $data[$this->_join['child'][0]]
				),
				array(
					$this->_join['parent'][1] => $parentId
				)
			);
		}
		else {
			// No link table, just a direct reference
			$set = array(
				$this->_join['child'] => $parentId
			);

			for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
				$field = $this->_fields[$i];

				if ( $field->apply( 'set', $data ) ) {
					$set[ $field->dbField() ] = $field->val('set', $data);
				}
			}

			// Add WHERE conditions
			$where = array($this->_join['child'] => $parentId);
			for ( $i=0, $ien=count($this->_where) ; $i<$ien ; $i++ ) {
				$where[ $this->_where[$i]['key'] ] = $this->_where[$i]['value'];

				// Is there any point in this? Is there any harm?
				if ( $this->_whereSet ) {
					$set[ $this->_where[$i]['key'] ] = $this->_where[$i]['value'];
				}
			}

			$db->push( $this->_table, $set, $where );
		}
	}


	/**
	 * Create an SQL string from the fields that this instance knows about for
	 * using in queries
	 *  @param string $direction Direction: 'get' or 'set'.
	 *  @private
	 */
	private function _fields ( $direction )
	{
		$fields = array();

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];

			if ( $field->apply( $direction, null ) ) {
				if ( strpos( $field->dbField() , "." ) === false ) {
					$fields[] = $this->_table.'.'.$field->dbField() ." as ".$field->dbField();;
				}
				else {
					$fields[] = $field->dbField();// ." as ".$field->dbField();
				}
			}
		}

		return $fields;
	}
}

