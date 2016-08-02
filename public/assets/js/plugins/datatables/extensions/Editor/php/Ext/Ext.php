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


/**
 * Base class for DataTables classes.
 */
class Ext {
	/**
	 * Static method to instantiate a new instance of a class.
	 *
	 * A factory method that will create a new instance of the class
	 * that has extended 'Ext'. This allows classes to be instantiated
	 * and then chained - which otherwise isn't available until PHP 5.4.
	 * If using PHP 5.4 or later, simply create a 'new' instance of the
	 * target class and chain methods as normal.
	 * @return Instantiated class
	 * @static
	 */
	public static function instantiate() {
		$rc = new \ReflectionClass( get_called_class() );

		return $rc->newInstanceArgs( func_get_args() );
	}

	/**
	 * Static method to instantiate a new instance of a class (shorthand of
	 * 'instantiate').
	 *
	 * This method performs exactly the same actions as the 'instantiate'
	 * static method, but is simply shorter and easier to type!
	 * @return Instantiated class
	 * @static
	 */
	public static function inst() {
		$rc = new \ReflectionClass( get_called_class() );

		return $rc->newInstanceArgs( func_get_args() );
	}

	/**
	 * Common getter / setter function for DataTables classes.
	 *
	 * This getter / setter method makes building getter / setting methods
	 * easier, by abstracting everything to a single function call.
	 *
	 * @param mixed &$prop The property to set
	 * @param mixed $val The value to set - if given as null, then we assume
	 *    that the function is being used as a getter.
	 * @param boolean $array Treat the target property as an array or not
	 *    (default false). If used as an array, then values passed in are added
	 *    to the $prop array.
	 *
	 * @return self|* Class instance if setting (allowing chaining), or
	 *    the value requested if getting.
	 * @internal
	 */
	protected function _getSet( &$prop, $val, $array = false ) {
		// Get
		if ( $val === null ) {
			return $prop;
		}

		// Set
		if ( $array ) {
			// Property is an array, merge or add to array
			is_array( $val ) ?
				$prop = array_merge( $prop, $val ) :
				$prop[] = $val;
		} else {
			// Property is just a value
			$prop = $val;
		}

		return $this;
	}
}

