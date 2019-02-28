<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 1/2/2019
 * Time: 2:54 PM
 */

namespace Qpdb\Common\Helpers;


use Qpdb\Common\Tree;

class Arrays
{

	/**
	 * @param mixed $array
	 * @param bool  $unique
	 * @return array
	 */
	public static function flattenValues( $array = [], $unique = false ) {
		$array = (array)$array;
		$return = array();
		array_walk_recursive( $array, function( $a ) use ( &$return ) {
			$return[] = $a;
		} );

		if ( $unique ) {
			return array_values( array_unique( $return ) );
		}

		return $return;
	}

	/**
	 * @param array        $array
	 * @param array|string $values
	 * @param bool         $onlyValues
	 * @return array
	 */
	public static function removeValues( array $array, $values = [], $onlyValues = false ) {
		$values = self::flattenValues( $values );
		if ( $onlyValues ) {
			return array_values( array_diff( $array, $values ) );
		}

		return array_diff( $array, $values );
	}

	/**
	 * @param array $flattenArray
	 * @return Tree
	 */
	public static function tree( array $flattenArray ) {
		return new Tree( $flattenArray );
	}

	/**
	 * @param array $arr
	 * @return bool
	 */
	public static function isAssoc( $arr ) {
		$arr = (array)$arr;

		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}


}