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


/**
 * Formatter methods for the DataTables Editor
 * 
 * All methods in this class are static with common inputs and returns.
 */
class Format {
	/** Date format: 2012-03-09. jQuery UI equivalent format: yy-mm-dd */
	const DATE_ISO_8601 = "Y-m-d";

	/** Date format: Fri, 9 Mar 12. jQuery UI equivalent format: D, d M y */
	const DATE_ISO_822 = "D, j M y";
	
	/** Date format: Friday, 09-Mar-12.  jQuery UI equivalent format: DD, dd-M-y */
	const DATE_ISO_850 = "l, d-M-y";
	
	/** Date format: Fri, 9 Mar 12. jQuery UI equivalent format: D, d M y */
	const DATE_ISO_1036 = "D, j M y";
	
	/** Date format: Fri, 9 Mar 2012. jQuery UI equivalent format: D, d M yy */
	const DATE_ISO_1123 = "D, j M Y";
	
	/** Date format: Fri, 9 Mar 2012. jQuery UI equivalent format: D, d M yy */
	const DATE_ISO_2822 = "D, j M Y";
	
	/** Date format: 1331251200. jQuery UI equivalent format: @ */
	const DATE_TIMESTAMP = "U";
	
	/** Date format: 1331251200. jQuery UI equivalent format: @ */
	const DATE_EPOCH = "U";


	/**
	 * Convert from SQL date / date time format to a format given by the options
	 * parameter.
	 *
	 * Typical use of this method is to use it with the 
	 * {@link Field::getFormatter} and {@link Field::setFormatter} methods of
	 * {@link Field} where the parameters required for this method will be 
	 * automatically satisfied.
	 *   @param string $val Value to convert from MySQL date format
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Format to convert to using PHP date() options.
	 *   @return string Formatted date or empty string on error.
	 */
	public static function date_sql_to_format( $val, $data, $opts ) {
		$date = new \DateTime( $val );

		// Allow empty strings or invalid dates
		if ( $val && $date ) {
			return date_format( $date, $opts );
		}
		return null;
	}


	/**
	 * Convert from from a format given by the options parameter to a format
	 * that SQL servers will recognise as a date.
	 *
	 * Typical use of this method is to use it with the 
	 * {@link Field::getFormatter} and {@link Field::setFormatter} methods of
	 * {@link Field} where the parameters required for this method will be 
	 * automatically satisfied.
	 *   @param string $val Value to convert to MySQL date format
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Format to convert from using PHP date() options.
	 *   @return string Formatted date or null on error.
	 */
	public static function date_format_to_sql( $val, $data, $opts ) {
		// Note that this assumes the date is in the correct format (should be
		// checked by validation before being used here!)
		$date = date_create_from_format($opts, $val);

		// Invalid dates or empty string are replaced with null. Use the
		// validation to ensure the date given is valid if you don't want this!
		if ( $val && $date ) {
			return date_format( $date, 'Y-m-d' );
		}
		return null;
	}


	/**
	 * Convert from one date time format to another
	 *
	 * Typical use of this method is to use it with the 
	 * {@link Field::getFormatter} and {@link Field::setFormatter} methods of
	 * {@link Field} where the parameters required for this method will be 
	 * automatically satisfied.
	 *   @param string $val Value to convert from MySQL date format
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Array with `from` and `to` properties which are the
	 *     formats to convert from and to
	 *   @return string Formatted date or empty string on error.
	 */
	public static function datetime( $val, $data, $opts ) {
		$date = date_create_from_format($opts['from'], $val);

		// Allow empty strings or invalid dates
		if ( $date ) {
			return date_format( $date, $opts['to'] );
		}
		return '';
	}


	/**
	 * Convert an array of values from a checkbox into a string which can be
	 * used to store in a text field in a database.
	 *   @param string $val Value to convert to from an array to a string
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Field delimiter
	 *   @return string Formatted date or null on error.
	 */
	public static function implode( $val, $data, $opts ) {
		if ( $opts === null ) {
			$opts = '|';
		}
		return implode($opts, $val);
	}


	/**
	 * Convert a string of values into an array for use with checkboxes.
	 *   @param string $val Value to convert to from a string to an array
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Field delimiter
	 *   @return string Formatted date or null on error.
	 */
	public static function explode( $val, $data, $opts ) {
		if ( $opts === null ) {
			$opts = '|';
		}
		return explode($opts, $val);
	}


	/**
	 * Convert an empty string to `null`. Null values are very useful in
	 * databases, but HTTP variables have no way of representing `null` as a
	 * value, often leading to an empty string and null overlapping. This method
	 * will check the value to operate on and return null if it is empty.
	 *   @param string $val Value to convert to from a string to an array
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Field delimiter
	 *   @return string Formatted date or null on error.
	 */
	public static function nullEmpty ( $val, $data, $opts ) {
		if ( $val === '' ) {
			return null;
		}
		return $val;
	}
}

