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
 * Field definitions for the DataTables Editor.
 *
 * Each Database column that is used with Editor can be described with this 
 * Field method (both for Editor and Join instances). It basically tells
 * Editor what table column to use, how to format the data and if you want
 * to read and/or write this column.
 *
 * Field instances are used with the {@link Editor::field} and 
 * {@link Join::field} methods to describe what fields should be interacted
 * with by the editable table.
 *
 *  @example
 *    Simply get a column with the name "city". No validation is performed.
 *    <code>
 *      Field::inst( 'city' )
 *    </code>
 *
 *  @example
 *    Get a column with the name "first_name" - when edited a value must
 *    be given due to the "required" validation from the {@link Validate} class.
 *    <code>
 *      Field::inst( 'first_name' )->validator( 'Validate::required' )
 *    </code>
 *
 *  @example
 *    Working with a date field, which is validated, and also has *get* and
 *    *set* formatters.
 *    <code>
 *      Field::inst( 'registered_date' )
 *          ->validator( 'Validate::dateFormat', 'D, d M y' )
 *          ->getFormatter( 'Format::date_sql_to_format', 'D, d M y' )
 *          ->setFormatter( 'Format::date_format_to_sql', 'D, d M y' )
 *    </code>
 *
 *  @example
 *    Using an alias in the first parameter
 *    <code>
 *      Field::inst( 'name.first as first_name' )
 *    </code>
 */
class Field extends DataTables\Ext {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Field instance constructor.
	 *  @param string $dbField Name of the database column
	 *  @param string $name Name to use in the JSON output from Editor and the
	 *    HTTP submit from the client-side when editing. If not given then the
	 *    $dbField name is used.
	 */
	function __construct( $dbField=null, $name=null )
	{
		if ( $dbField !== null && $name === null ) {
			// Allow just a single parameter to be passed - each can be 
			// overridden if needed later using the API.
			$this->name( $dbField );
			$this->dbField( $dbField );
		}
		else {
			$this->name( $name );
			$this->dbField( $dbField );
		}
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private parameters
	 */

	/** @var string */
	private $_dbField = null;

	/** @var boolean */
	private $_get = true;

	/** @var mixed */
	private $_getFormatter = null;

	/** @var mixed */
	private $_getFormatterOpts = null;

	/** @var string */
	private $_name = null;

	/** @var boolean */
	private $_set = true;

	/** @var mixed */
	private $_setFormatter = null;

	/** @var mixed */
	private $_setFormatterOpts = null;

	/** @var mixed */
	private $_validator = null;

	/** @var mixed */
	private $_validatorOpts = null;



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */


	/**
	 * Get / set the DB field name.
	 * 
	 * Note that when used as a setter, an alias can be given for the field
	 * using the SQL `as` keyword - for example: `firstName as name`. In this
	 * situation the dbField is set to the field name before the `as`, and the
	 * field's name (`name()`) is set to the name after the ` as `.
	 *
	 * As a result of this, the following constructs have identical
	 * functionality:
	 *
	 *    Field::inst( 'firstName as name' );
	 *    Field::inst( 'firstName', 'name' );
	 *
	 *  @param string $_ Value to set if using as a setter.
	 *  @return string|self The name of the db field if no parameter is given,
	 *    or self if used as a setter.
	 */
	public function dbField ( $_=null )
	{
		if ( $_ === null ) {
			return $this->_dbField;
		}

		if ( strpos( $_, ' as ' ) ) {
			$a = explode( ' as ', $_ );
			$this->_dbField = trim( $a[0] );
			$this->_name = trim( $a[1] );
		}
		else {
			$this->_dbField = $_;
		}

		return $this;
	}


	/**
	 * Get / set the 'get' property of the field.
	 *
	 * A field can be marked as write only when setting the get property to false
	 * here.
	 *  @param boolean $_ Value to set if using as a setter.
	 *  @return boolean|self The get property if no parameter is given, or self
	 *    if used as a setter.
	 */
	public function get ( $_=null )
	{
		return $this->_getSet( $this->_get, $_ );
	}


	/**
	 * Get formatter for the field's data.
	 *
	 * When the data has been retrieved from the server, it can be passed through
	 * a formatter here, which will manipulate (format) the data as required. This
	 * can be useful when, for example, working with dates and a particular format
	 * is required on the client-side.
	 *
	 * Editor has a number of formatters available with the {@link Format} class
	 * which can be used directly with this method.
	 *  @param function|string $_ Value to set if using as a setter. Can be given as
	 *    a closure function or a string with a reference to a function that will
	 *    be called with call_user_func().
	 *  @param mixed $opts Variable that is passed through to the get formatting
	 *    function - can be useful for passing through extra information such as
	 *    date formatting string, or a required flag. The actual options available
	 *    depend upon the formatter used.
	 *  @return function|string|self The get formatter if no parameter is given, or 
	 *    self if used as a setter.
	 */
	public function getFormatter ( $_=null, $opts=null )
	{
		if ( $opts !== null ) {
			$this->_getFormatterOpts = $opts;
		}
		return $this->_getSet( $this->_getFormatter, $_ );
	}


	/**
	 * Get / set the 'name' property of the field.
	 *
	 * The name is typically the same as the dbField name, since it makes things
	 * less confusing(!), but it is possible to set a different name for the data
	 * which is used in the JSON returned to DataTables in a 'get' operation and
	 * the field name used in a 'set' operation.
	 *  @param string $_ Value to set if using as a setter.
	 *  @return string|self The name property if no parameter is given, or self
	 *    if used as a setter.
	 */
	public function name ( $_=null )
	{
		return $this->_getSet( $this->_name, $_ );
	}


	/**
	 * Get / set the 'set' property of the field.
	 *
	 * A field can be marked as read only when setting the get property to false
	 * here.
	 *  @param boolean $_ Value to set if using as a setter.
	 *  @return boolean|self The set property if no parameter is given, or self
	 *    if used as a setter.
	 */
	public function set ( $_=null )
	{
		return $this->_getSet( $this->_set, $_ );
	}


	/**
	 * Set formatter for the field's data.
	 *
	 * When the data has been retrieved from the server, it can be passed through
	 * a formatter here, which will manipulate (format) the data as required. This
	 * can be useful when, for example, working with dates and a particular format
	 * is required on the client-side.
	 * Editor has a number of formatters available with the {@link Format} class
	 * which can be used directly with this method.
	 *  @param function|string $_ Value to set if using as a setter. Can be given as
	 *    a closure function or a string with a reference to a function that will
	 *    be called with call_user_func().
	 *  @param mixed $opts Variable that is passed through to the get formatting
	 *    function - can be useful for passing through extra information such as
	 *    date formatting string, or a required flag. The actual options available
	 *    depend upon the formatter used.
	 *  @return function|string|self The set formatter if no parameter is given, or 
	 *    self if used as a setter.
	 */
	public function setFormatter ( $_=null, $opts=null )
	{
		if ( $opts !== null ) {
			$this->_setFormatterOpts = $opts;
		}
		return $this->_getSet( $this->_setFormatter, $_ );
	}


	/**
	 * Get / set the 'validator' of the field.
	 *
	 * The validator can be used to check if any abstract piece of data is valid
	 * or not according to the given rules of the validation function used.
	 * Editor has a number of validation available with the {@link Validate} class
	 * which can be used directly with this method.
	 *  @param function|string $_ Value to set if using as the validation method. 
	 *    Can be given as a closure function or a string with a reference to a 
	 *    function that will be called with call_user_func().
	 *  @param mixed $opts Variable that is passed through to the validation
	 *    function - can be useful for passing through extra information such as
	 *    date formatting string, or a required flag. The actual options available
	 *    depend upon the validation function used.
	 *  @return function|string|self The validation method if no parameter is given, 
	 *    or self if used as a setter.
	 */
	public function validator ( $_=null, $opts=null )
	{
		if ( $opts !== null ) {
			$this->_validatorOpts = $opts;
		}
		return $this->_getSet( $this->_validator, $_ );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	/**
	 * Check to see if a field should be used for a particular action (get or set).
	 *
	 * Called by the Editor / Join class instances - not expected for general
	 * consumption - internal.
	 *  @param string $direction Direction that the data is travelling  - 'get' is
	 *    reading data, and 'set' is writing it to the DB.
	 *  @param array $data Data submitted from the client-side when setting.
	 *  @return boolean true if the field should be used in the get / set.
	 *  @internal
	 */
	public function apply ( $direction, $data=null )
	{
		if ( $direction === 'get' ) {
			// Get action - can we get this field
			return $this->_get;
		}
		else {
			// Note that validation must be done on input data before we get here
			// Set action - can we set this field
			if ( ! $this->_set ) {
				return false;
			}

			// Check it it was in the submitted data. It not, then not required
			// (validation would have failed if it was) and therefore we don't
			// set it. Check for a set formatter as well, as it can format data
			// from some other source
			if ( ! $this->_setFormatter && ! $this->_inData( $this->name(), $data ) ) {
				return false;
			}

			// In the data set, so use it
			return true;
		}
	}


	/**
	 * Get the value of the field, taking into account if it is coming from the
	 * DB or from a POST. If formatting has been specified for this field, it
	 * will be applied here.
	 *
	 * Called by the Editor / Join class instances - not expected for general
	 * consumption - internal.
	 *  @param string $direction Direction that the data is travelling  - 'get' is
	 *    reading data, and 'set' is writing it to the DB.
	 *  @param array $data Data submitted from the client-side when setting or the
	 *    data for the row when getting data from the DB.
	 *  @return string Value for the field
	 *  @internal
	 */
	public function val ( $direction, $data )
	{
		if ( $direction === 'get' ) {
			// Use data from the database, so the db name
			$namedData = isset( $data[ $this->_dbField ] ) ?
				$data[ $this->_dbField ] :
				null;

			// Three cases for the getFormatter - closure, string or null
			if ( $this->_getFormatter ) {
				if ( is_string( $this->_getFormatter ) ) {
					// Don't require the Editor namespace if DataTables validator is given as a string
					if ( strpos($this->_getFormatter, "Format::") === 0 ) {
						// Editor formatter
						return call_user_func(
							"\\DataTables\\Editor\\".$this->_getFormatter,
							$namedData,
							$data,
							$this->_getFormatterOpts
						);
					}

					// User function (string identifier)
					return call_user_func(
						$this->_getFormatter,
						$namedData,
						$data,
						$this->_getFormatterOpts
					);
				}

				// Closure
				$getFormatter = $this->_getFormatter;
				return $getFormatter(
					$namedData,
					$data,
					$this->_getFormatterOpts
				);
			}
			return $namedData;
		}
		else {
			// Use data for settings from the POST / GET data, so use the name
			$namedData = $this->_readProp( $this->name(), $data );

			// Three cases for the setFormatter - closure, string or null
			if ( $this->_setFormatter ) {
				if ( is_string( $this->_setFormatter ) ) {
					// Don't require the Editor namespace if DataTables validator is given as a string
					if ( strpos($this->_setFormatter, "Format::") === 0 ) {
						// Editor formatter
						return call_user_func(
							"\\DataTables\\Editor\\".$this->_setFormatter,
							$namedData,
							$data,
							$this->_setFormatterOpts
						);
					}

					// User function (string identifier)
					return call_user_func(
						$this->_setFormatter,
						$namedData,
						$data,
						$this->_setFormatterOpts
					);
				}

				// Closure
				$setFormatter = $this->_setFormatter;
				return $setFormatter(
					$namedData,
					$data,
					$this->_setFormatterOpts
				);
			}
			return $namedData;
		}
	}

	public function write( &$out, $data )
	{
		$this->_writeProp( $out, $this->name(), $this->val('get', $data) );
	}



	/**
	 * Check the validity of the field based on the data submitted. Note that
	 * this validation is performed on the wire data - i.e. that which is
	 * submitted, before any setFormatter is run
	 *
	 * Called by the Editor / Join class instances - not expected for general
	 * consumption - internal.
	 *  @param array $data Data submitted from the client-side 
	 *  @param Editor $editor Editor instance
	 *  @return boolean Indicate if a field is valid or not.
	 *  @internal
	 */
	public function validate ( $data, $editor )
	{
		// Three cases for the validator - closure, string or null
		if ( ! $this->_validator ) {
			return true;
		}

		$val = $this->_readProp( $this->name(), $data );

		if ( is_string( $this->_validator ) ) {
			$processData = $editor->inData();
			$instances = array(
				'action' => $processData['action'],
				'id'     => isset($processData['id']) ?
					str_replace( $editor->idPrefix(), '', $processData['id'] ) :
					null,
				'field'  => $this,
				'editor' => $editor,
				'db'     => $editor->db()
			);

			// Don't require the Editor namespace if DataTables validator is given as a string
			if ( strpos($this->_validator, "Validate::") === 0 ) {
				return call_user_func( "\\DataTables\\Editor\\".$this->_validator, $val, $data, $this->_validatorOpts, $instances );
			}
			return call_user_func( $this->_validator, $val, $data, $this->_validatorOpts, $instances );
		}
		$validator = $this->_validator;
		return $validator( $val, $data, $this );
	}






	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Write the field's value to an array structure, using Javascript dotted
	 * object notation to indicate JSON data structure. For example `name.first`
	 * gives the data structure: `name: { first: ... }`. This matches DataTables
	 * own ability to do this on the client-side, although this doesn't
	 * implement implement quite such a complex structure (no array / function
	 * support).
	 *
	 * @param  array  &$out   Array to write the data to
	 * @param  string  $name  Javascript dotted object name to write to
	 * @param  *       $value Value to write
	 * @private
	 */
	private function _writeProp( &$out, $name, $value )
	{
		if ( strpos($name, '.') === false ) {
			$out[ $name ] = $value;
			return;
		}

		$orig = $name;
		$names = explode( '.', $name );
		$inner = &$out;
		for ( $i=0 ; $i<count($names)-1 ; $i++ ) {
			$name = $names[$i];

			if ( ! isset( $inner[ $name ] ) ) {
				$inner[ $name ] = array();
			}
			else if ( ! is_array( $inner[ $name ] ) ) {
				throw new \Exception(
					'A property with the name `'.$name.'` already exists. This '.
					'can occur if you have properties which share a prefix - '.
					'for example `name` and `name.first`.'
				);
			}

			$inner = &$inner[ $name ];
		}

		if ( isset( $inner[ $names[count($names)-1] ] ) ) {
			throw new \Exception(
				'Duplicate field detected - a field with the name `'.$orig.'` '.
				'already exists.'
			);
		}

		$inner[ $names[count($names)-1] ] = $value;
	}


	/**
	 * Read a value from a data structure, using Javascript dotted object
	 * notation. This is the inverse of the `_writeProp` method and provides
	 * the same support, matching DataTables' ability to read nested JSON
	 * data objects.
	 *
	 * @param  string $name  Javascript dotted object name to write to
	 * @param  array  $out   Data source array to read from
	 * @return *             The read value, or null if no value found.
	 * @private
	 */
	private function _readProp ( $name, $data )
	{
		if ( strpos($name, '.') === false ) {
			return isset( $data[ $name ] ) ?
				$data[ $name ] :
				null;
		}

		$names = explode( '.', $name );
		$inner = $data;

		for ( $i=0 ; $i<count($names)-1 ; $i++ ) {
			if ( ! isset( $inner[ $names[$i] ] ) ) {
				return null;
			}

			$inner = $inner[ $names[$i] ];
		}

		if ( isset( $names[count($names)-1] ) ) {
			$idx = $names[count($names)-1];

			return isset( $inner[ $idx ] ) ?
				$inner[ $idx ] :
				null;
		}
		return null;
	}


	/**
	 * Check is a parameter is in the submitted data set. This is functionally
	 * the same as the `_readProp()` method, but in this case a binary value
	 * is required to indicate if the value is present or not.
	 *
	 * @param  string $name  Javascript dotted object name to write to
	 * @param  array  $out   Data source array to read from
	 * @return boolean       `true` if present, `false` otherwise
	 * @private
	 */
	private function _inData ( $name, $data )
	{
		if ( strpos($name, '.') === false ) {
			return isset( $data[ $name ] ) ?
				true :
				false;
		}

		$names = explode( '.', $name );
		$inner = $data;

		for ( $i=0 ; $i<count($names)-1 ; $i++ ) {
			if ( ! isset( $inner[ $names[$i] ] ) ) {
				return false;
			}

			$inner = $inner[ $names[$i] ];
		}

		return isset( $names[count($names)-1] ) ?
			true :
			false;
	}
}

