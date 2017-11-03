<?php namespace TheStringler\Manipulator;

use Doctrine\Common\Inflector\Inflector;

class Manipulator
{
    /**
     * @var string
     */
    protected $string;

    /**
     * @param string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }

    /**
     * Append to the string.
     *
     * @param  string
     * @return object
     */
    public function append($string)
    {
        return new static($this->string . $string);
    }

    /**
     * Convert a camel-case string to snake-case.
     *
     * @return object
     */
    public function camelToSnake()
    {
        $modifiedString = '';

        foreach (str_split($this->string, 1) as $character) {
            $modifiedString .= ctype_upper($character) ? '_' . $character : $character;
        }

        return new static(strtolower($modifiedString));
    }

    /**
     * Capitalize the string.
     *
     * @return object
     */
    public function capitalize()
    {
        return new static(ucfirst($this->string));
    }

    /**
     * Capitalize each word in the string.
     *
     * @return object
     */
    public function capitalizeEach()
    {
        $modifiedString = '';

        foreach (explode(' ', $this->string) as $word) {
            $modifiedString .= ucfirst($word) . ' ';
        }

        return new static(trim($modifiedString));
    }

    /**
     * Get Possessive Version of String
     *
     * @return object
     */
    public function getPossessive()
    {
        $modifiedString = $this->trimEnd();

        if(substr($modifiedString, -1) === 's') {
            $modifiedString .= '\'';
        } else {
            $modifiedString .= '\'s';
        }

        return new static($modifiedString);
    }

    /**
     * Decode HTML Entities
     *
     * @param  constant $flags
     * @param  string   $encoding
     * @return object
     */
    public function htmlEntitiesDecode($flags = ENT_HTML5, $encoding = 'UTF-8')
    {
        return new static(html_entity_decode($this->string, $flags, $encoding));
    }

    /**
     * HTML Entities
     *
     * @param  constant  $flags
     * @param  string    $encoding
     * @param  boolean   $doubleEncode
     * @return object
     */
    public function htmlEntities($flags = ENT_HTML5, $encoding = 'UTF-8', $doubleEncode = true)
    {
        return new static(htmlentities($this->string, $flags, $encoding, $doubleEncode));
    }

    /**
     * HTML Special Characters
     *
     * @param  constant  $flags
     * @param  string    $encoding
     * @param  boolean   $doubleEncode
     * @return object
     */
    public function htmlSpecialCharacters($flags = ENT_HTML5, $encoding = 'UTF-8', $doubleEncode = true)
    {
        return new static(htmlspecialchars($this->string, $flags, $encoding, $doubleEncode));
    }

    /**
     * Make the first letter of the string
     * lowercase.
     *
     * @return object
     */
    public function lowercaseFirst()
    {
        return new static(lcfirst($this->string));
    }

    /**
     * Named Constructor
     *
     * @return object
     */
    public static function make($string)
    {
        return new static($string);
    }

    /**
     * Pluaralize String
     *
     * @return object
     */
    public function pluralize()
    {
        return new static(Inflector::pluralize($this->string));
    }

    /**
     * Prepend the string.
     *
     * @param  string
     * @return object
     */
    public function prepend($string)
    {
        return new static($string . $this->string);
    }

    /**
     * Remove from string.
     *
     * @param  string
     * @return object
     */
    public function remove($string, $caseSensitive = true)
    {
        return new static($this->replace($string, '', $caseSensitive)->toString());
    }

    /**
     * Remove non-alphanumeric characters.
     *
     * @return object
     */
    public function removeSpecialCharacters()
    {
        $modifiedString = preg_replace("/[^\w\d]/", '', $this->string);
        return new static($modifiedString);
    }

    /**
     * Repeat a string.
     *
     * @param  integer $multiplier
     * @return object
     */
    public function repeat($multiplier = 1)
    {
        return new static(str_repeat($this->string, $multiplier));
    }

    /**
     * Replace
     *
     * @param string $find
     * @param string $replace
     * @param bool   $caseSensitive
     * @return object
     */
    public function replace($find, $replace = '', $caseSensitive = true)
    {
        if ($caseSensitive) {
            return new static(str_replace($find, $replace, $this->string));
        } else {
            return new static(str_ireplace($find, $replace, $this->string));
        }

    }

    /**
     * Reverse
     *
     * @return object
     */
    public function reverse()
    {
        return new static(strrev($this->string));
    }

    /**
     * Convert snake-case to camel-case.
     *
     * @return object
     */
    public function snakeToCamel()
    {
        $modifiedString = $this->replace('_', ' ')
            ->capitalizeEach()
            ->lowercaseFirst()
            ->remove(' ')
            ->toString();

        return new static($modifiedString);
    }

    /**
     * Strip HTML/PHP Tags
     *
     * @param string $allowed
     * @return object
     */
    public function stripTags($allowed = '')
    {
        $modifiedString = strip_tags($this->string, $allowed);
        return new static($modifiedString);
    }

    /**
     * Convert a string to camel-case.
     *
     * @return object
     */
    public function toCamelCase()
    {
        $modifiedString = '';

        foreach (explode(' ', $this->string) as $word) {
            $modifiedString .= ucfirst(strtolower($word));
        }

        return new static(lcfirst(str_replace(' ', '', $modifiedString)));
    }

    /**
     * Convert the string to lowercase.
     *
     * @return object
     */
    public function toLower()
    {
        return new static(strtolower($this->string));
    }

    /**
     * Convert string to slug
     *
     * @return object
     */
    public function toSlug()
    {
        $modifiedString = $this->toLower()
            ->replace(' ', '-')
            ->toString();

        return new static(preg_replace("/[^\w\d\-]/", '', $modifiedString));
    }

    /**
     * Convert string to snake-case
     *
     * @return object
     */
    public function toSnakeCase()
    {
        $modifiedString = $this->toLower()
            ->replace(' ', '_')
            ->toString();

        return new static($modifiedString);
    }

    /**
     * Return the string.
     *
     * @return string
     */
    public function toString()
    {
        return $this->string;
    }

    /**
     * Capitalize entire string.
     *
     * @return object
     */
    public function toUpper()
    {
        return new static(strtoupper($this->string));
    }

    /**
     * Trim
     *
     * @return object
     */
    public function trim()
    {
        return new static(trim($this->string));
    }

    /**
     * Trim the beginning of the string.
     *
     * @return object
     */
    public function trimBeginning()
    {
        return new static(ltrim($this->string));
    }

    /**
     * Trim the end of the string.
     *
     * @return object
     */
    public function trimEnd()
    {
        return new static(rtrim($this->string));
    }

    /**
     * Truncate
     *
     * @param int    $length
     * @param string $append
     * @return object
     */
    public function truncate($length = 100, $append = '...')
    {
        $modifiedString = substr($this->string, 0, $length) . $append;
        return new static($modifiedString);
    }

    /**
     * Decode URL
     *
     * @return object
     */
    public function urlDecode()
    {
        return new static(urldecode($this->string));
    }

    /**
     * Encode URL
     *
     * @return object
     */
    public function urlEncode()
    {
        return new static(urlencode($this->string));
    }

}
