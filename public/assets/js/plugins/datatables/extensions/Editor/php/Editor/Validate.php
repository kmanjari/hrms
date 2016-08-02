<?php
/**
 * DataTables PHP libraries.
 *
 * PHP libraries for DataTables and DataTables Editor, utilising PHP 5.3+.
 *
 *  @author    SpryMedia
 *  @copyright 2012-2014 SpryMedia ( http://sprymedia.co.uk )
 *  @license   http://editor.datatables.net/license DataTables Editor
 *  @link      http://editor.datatables.net
 */

namespace DataTables\Editor;
if (!defined('DATATABLES')) exit();


/**
 * Validation methods for DataTables Editor fields.
 *
 * These methods will typically be applied through the {@link Field::validator}
 * method and thus the arguments to be passed will be automatically resolved
 * by Editor.
 *
 * The validation methods in this class all take three parameters:
 *
 * 1. Data to be validated
 * 2. Full data from the form (this can be used with a custom validation method
 *    for dependent validation).
 * 3. Validation configuration options.
 *
 * When using the `Validate` class functions with the {@link Field::validator}
 * method, the second parameter passed into {@link Field::validator} is given
 * to the validation functions here as the third parameter. The first and
 * second parameters are automatically resolved by the {@link Field} class.
 *
 * The validation configuration options is an array of options that can be used
 * to customise the validation - for example defining a date format for date
 * validation. Each validation method has the option of defining its own
 * validation options, but all validation methods provide four common options:
 *
 * * `{boolean} optional` - Require the field to be submitted (`false`) or not
 *   (`true` - default). When set to `true` the field does not need to be
 *   included in the list of parameters sent by the client - if set to `false`
 *   then it must be included. This option can be be particularly used in Editor
 *   as Editor will not set a value for fields which have not been submitted -
 *   giving the ability to submit just a partial list of options.
 * * `{boolean} empty` - Allow a field to be empty, i.e. a zero length string -
 *   `''` (`true` - default) or require it to be non-zero length (`false`).
 * * `{boolean} required` - Short-cut for `optional=false` and `empty=false`.
 *   Note that if this option is set the `optional` and `empty` parameters are
 *   automatically set and cannot be overridden by passing in different values.
 * * `{string} message` - Error message shown should validation fail. This
 *   provides complete control over the message shown to the end user, including
 *   internationalisation (i.e. to provide a translation that is not in the
 *   English language).
 *
 *  @example
 *    <code>
 *      // Ensure that a non-empty value is given for a field
 *      Field::inst( 'engine' )->validator( 'Validate::required' )
 *    </code>
 *
 *  @example
 *    <code>
 *      // Don't require a field to be submitted, but if it is submitted, it
 *      // must be non-empty
 *      Field::inst( 'reg_date' )->validator( 'Validate::notEmpty' )
 *
 * 	    // or (this is identical in functionality to the line above):
 *      Field::inst( 'reg_date' )->validator( 'Validate::basic', array('empty'=>true) )
 *    </code>
 *
 *  @example
 *    <code>
 *      // Date validation
 *      Field::inst( 'reg_date' )->validator( 'Validate::date_format', 'D, d M y' )
 *    </code>
 *
 *  @example
 *    <code>
 *      // Date validation with a custom error message
 *      Field::inst( 'reg_date' )->validator( 'Validate::date_format', array(
 *          'format'  => 'D, d M y',
 *          'message' => "Invalid date"
 *      ) )
 *    </code>
 *
 *  @example
 *    <code>
 *      // Require a non-empty e-mail address
 *      Field::inst( 'reg_date' )->validator( 'Validate::email', array('required'=>true) )
 *
 * 	    // or (this is identical in functionality to the line above):
 *      Field::inst( 'reg_date' )->validator( 'Validate::email', array(
 *          'empty'    => false,
 *          'optional' => false
 *      ) )
 *    </code>
 *
 *  @example
 *    <code>
 *      // Custom validation - closure
 *      Field::inst( 'engine' )->validator( function($val, $data, $opts) {
 *         if ( ! preg_match( '/^1/', $val ) ) {
 *           return "Value <b>must</b> start with a 1";
 *         }
 *         return true;
 *      } )
 *    </code>
 */
class Validate {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal functions
	 */

	/**
	 * "Magic" method to automatically apply the required check to any of the
	 * static methods simply by adding '_required' or '_empty' to the end of the
	 * method's name, depending on if you need the field to be submitted or not.
	 *
	 * This is retained for backwards compatibility, but the validation options
	 * are now the recommended way of indicating that a field is required.
	 *
	 *  @internal
	 */
	public static function __callStatic( $name, $arguments ) {
		if ( preg_match( '/_required$/', $name ) ) {
			if ( $arguments[0] === null || $arguments[0] === '' ) {
				return 'This field is required';
			}

			return call_user_func_array( 
				__NAMESPACE__.'\Validate::'.str_replace( '_required', '', $name ),
				$arguments
			);
		}
	}


	/**
	 * Extend the options from the user function and the validation function
	 * with core defaults.
	 *
	 *  @internal
	 */
	public static function _extend( $userOpts, $prop, $fnOpts ) {
		$cfg = array(
			'message'  => 'Input not valid',
			'required' => false,
			'empty'    => true,
			'optional' => true
		);

		if ( ! is_array( $userOpts ) ) {
			if ( $prop ) {
				$cfg[ $prop ] = $userOpts;
			}

			// Not an array, but the non-array case has been handled above, so
			// just an empty array
			$userOpts = array();
		}

		// Merge into a single array - first array gets priority if there is a
		// key clash, so user first, then function commands and finally the
		// global options 
		$cfg = $userOpts + $fnOpts + $cfg;

		return $cfg;
	}


	/**
	 * Perform common validation using the configuration parameters
	 *
	 *  @internal
	 */
	public static function _common( $val, $cfg ) {
		// `required` is a shortcut for optional==false && empty==false
		$optional = $cfg['required'] ? false : $cfg['optional'];
		$empty    = $cfg['required'] ? false : $cfg['empty'];

		// Error state tests
		if ( ! $optional && $val === null  ) {
			// Value must be given
			return $cfg['message'];
		}
		else if ( ! $empty && $val === '' ) {
			// Value must not be empty
			return $cfg['message'];
		}

		// Validation passed states
		if ( $optional && $val === null ) {
			return true;
		}
		else if ( $empty && $val === '' ) {
			return true;
		}

		// Have the specific validation function perform its tests
		return null;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Basic validation
	 */

	/**
	 * No validation - all inputs are valid.
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return true
	 */
	public static function none( $val, $data, $opts, $host ) {
		return true;
	}


	/**
	 * Basic validation - this is used to perform the validation provided by the
	 * validation options only. If the validation options pass (e.g. `required`,
	 * `empty` and `optional`) then the validation will pass regardless of the
	 * actual value.
	 *
	 * Note that there are two helper short-cut methods that provide the same
	 * function as this method, but are slightly shorter:
	 *
	 * ```
	 * // Required:
	 * Validate::required()
	 *
	 * // is the same as
	 * Validate::basic( $val, $data, array(
	 *   "required" => true
	 * );
	 * ```
	 *
	 * ```
	 * // Optional, but not empty if given:
	 * Validate::notEmpty()
	 *
	 * // is the same as
	 * Validate::basic( $val, $data, array(
	 *   "empty" => false
	 * );
	 * ```
	 * 
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	static function basic( $val, $data, $opts, $host ) {
		// Common validation with user override option
		$cfg = Validate::_extend( $opts, null, array() );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return true;
	}


	/**
	 * Required field - there must be a value and it must be a non-empty value
	 *
	 * This is a helper short-cut method which is the same as:
	 * 
	 * ```
	 * Validate::basic( $val, $data, array(
	 *   "required" => true
	 * );
	 * ```
	 * 
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	static function required( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message'  => "This field is required",
			'required' => true
		) );

		$common = Validate::_common( $val, $cfg );
		return $common !== null ?
			$common :
			true;
	}


	/**
	 * Optional field, but if given there must be a non-empty value
	 *
	 * This is a helper short-cut method which is the same as:
	 * 
	 * ```
	 * Validate::basic( $val, $data, array(
	 *   "empty" => false
	 * );
	 * ```
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	static function notEmpty( $val, $data, $opts, $host ) {
		// Supplying this field is optional, but if given, then it must be
		// non-empty (user can override by passing in `empty=true` in opts
		// at which point there is basically no validation
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "This field is required",
			'empty'   => false
		) );

		$common = Validate::_common( $val, $cfg );
		return $common !== null ?
			$common :
			true;
	}


	/**
	 * Validate an input as a boolean value.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function boolean( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter true or false"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		if ( filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === false ) {
			return $cfg['message'];
		}
		return true;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Number validation methods
	 */

	/**
	 * Check that any input is numeric.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function numeric ( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "This input must be given as a number"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return ! is_numeric( $val ) ?
			$cfg['message'] :
			true;
	}

	/**
	 * Check for a numeric input and that it is greater than a given value.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `min` is available for this method to indicate the minimum value. If
	 *    only the default validation options are required, this parameter can
	 *    be given as an integer value, which will be used as the minimum value.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minNum ( $val, $data, $opts, $host ) {
		// `numeric` will do the common validation for us
		$numeric = Validate::numeric( $val, $data, $opts, $host );
		if ( $numeric !== true ) {
			return $numeric;
		}

		$min = is_array($opts) ? $opts['min'] : $opts;
		$cfg = Validate::_extend( $opts, 'min', array(
			'message' => "Number is too small, must be ".$min." or larger"
		) );

		return $val < $min ?
			$cfg['message'] :
			true;
	}

	/**
	 * Check for a numeric input and that it is less than a given value.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `max` is available for this method to indicate the maximum value. If
	 *    only the default validation options are required, this parameter can
	 *    be given as an integer value, which will be used as the maximum value.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function maxNum ( $val, $data, $opts, $host ) {
		// `numeric` will do the common validation for us
		$numeric = Validate::numeric( $val, $data, $opts, $host );
		if ( $numeric !== true ) {
			return $numeric;
		}

		$max = is_array($opts) ? $opts['max'] : $opts;
		$cfg = Validate::_extend( $opts, 'min', array(
			'message' => "Number is too large, must be ".$max." or smaller"
		) );

		return $val > $max ?
			$cfg['message'] :
			true;
	}


	/**
	 * Check for a numeric input and that it is both greater and smaller than
	 * given numbers.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional options of
	 *    `min` and `max` are available for this method to indicate the minimum
	 *    and maximum values, respectively.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minMaxNum ( $val, $data, $opts, $host ) {
		$numeric = Validate::numeric( $val, $data, $opts, $host );
		if ( $numeric !== true ) {
			return $numeric;
		}

		$min = Validate::minNum( $val, $data, $opts, $host );
		if ( $min !== true ) {
			return $min;
		}

		return Validate::maxNum( $val, $data, $opts, $host );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * String validation methods
	 */

	/**
	 * Validate an input as an e-mail address.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function email( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter a valid e-mail address"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return filter_var($val, FILTER_VALIDATE_EMAIL) !== false ?
			true :
			$cfg['message'];
	}


	/**
	 * Validate a string has a minimum length.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `min` is available for this method to indicate the minimum string
	 *    length. If only the default validation options are required, this
	 *    parameter can be given as an integer value, which will be used as the
	 *    minimum string length.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minLen( $val, $data, $opts, $host ) {
		$min = is_array($opts) ? $opts['min'] : $opts;
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "The input is too short. ".$min." characters required (".($min-strlen($val))." more required)"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return strlen( $val ) < $min ?
			$cfg['message'] :
			true;
	}


	/**
	 * Validate a string does not exceed a maximum length.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `max` is available for this method to indicate the maximum string
	 *    length. If only the default validation options are required, this
	 *    parameter can be given as an integer value, which will be used as the
	 *    maximum string length.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function maxLen( $val, $data, $opts, $host ) {
		$max = is_array($opts) ? $opts['max'] : $opts;
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "The input is ".(strlen($val)-$max)." characters too long"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return strlen( $val ) > $max ?
			$cfg['message'] :
			true;
	}

	/**
	 * Require a string with a certain minimum or maximum number of characters.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional options of
	 *    `min` and `max` are available for this method to indicate the minimum
	 *    and maximum string lengths, respectively.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minMaxLen( $val, $data, $opts, $host ) {
		$min = Validate::minLen( $val, $data, $opts, $host );
		if ( $min !== true ) {
			return $min;
		}

		return Validate::maxLen( $val, $data, $opts, $host );
	}


	/**
	 * Validate as an IP address.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function ip( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter a valid IP address"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return filter_var($val, FILTER_VALIDATE_IP) === false ?
			$cfg['message'] :
			true;
	}


	/**
	 * Validate as an URL address.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function url( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter a valid URL"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return filter_var($val, FILTER_VALIDATE_URL) === false ?
			$cfg['message'] :
			true;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Date validation methods
	 */

	/**
	 * Check that a valid date input is given
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array|string $opts If given as a string, then $opts is the date
	 *    format to check the validity of. If given as an array, then the
	 *    date format is in the 'format' parameter, and the return error
	 *    message in the 'message' parameter.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function dateFormat( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, 'format', array(
			'message' => "Date is not in the expected format"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		$date = \DateTime::createFromFormat( $cfg['format'], $val) ;

		return $date && $date->format( $cfg['format'] ) == $val ?
			true :
			$cfg['message'];
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Database validation methods
	 */

	/**
	 * Check that the given value is unique in the database
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional options of
	 *    `db` - database connection object, `table` - database table to use and
	 *    `column` - the column to check this value against as value, are also
	 *    available. These options are not required and if not given are
	 *    automatically derived from the Editor and Field instances.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function unique( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => 'This field must have a unique value',
			'db'      => null,
			'table'   => null,
			'field'   => null
		) );

		$editor = $host['editor'];
		$field = $host['field'];

		$db = $cfg['db'] ?
			$cfg['db'] :
			$host['db'];

		$table = $cfg['table'] ?
			$cfg['table'] :
			$editor->table(); // Returns an array, but `select` will take an array

		$column = $cfg['field'] ?
			$cfg['field'] :
			$field->dbField();

		$query = $db
			->query( 'select', $table )
			->get( $column )
			->where( $column, $val );

		// If doing an edit, then we need to also discount the current row,
		// since it is of course already validly unique
		if ( $host['action'] === 'edit' ) {
			$query->where( $editor->pkey(), $host['id'], '!=' ); 
		}

		$res = $query->exec();

		return $res->count() === 0 ?
			true :
			$cfg['message']; 
	}
}

