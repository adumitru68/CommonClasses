<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 10/13/2018
 * Time: 9:37 PM
 */

namespace Qpdb\Common\Helpers;


class Strings
{

	/**
	 * @param string $string
	 * @return string
	 */
	public static function htmlEntities( $string = '' ) {
		$string = preg_replace( "/(\r?\n){2,}/", "\n\n", $string );

		return htmlentities( $string, ENT_COMPAT | ENT_HTML5, 'utf-8' );
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public static function htmlEntitiesDecode( $string = '' ) {
		return html_entity_decode( $string, ENT_COMPAT | ENT_HTML5, 'utf-8' );
	}


	/**
	 * @param string|array $string
	 * @param bool         $withTrim
	 * @return null|string|string[]
	 */
	public static function removeMultipleSpace( $string, $withTrim = false ) {

		$newString = preg_replace( '/\s+/', ' ', $string );
		if ( $withTrim ) {
			return trim( $newString );
		}

		return $newString;
	}

	/**
	 * @param string $input
	 * @param string $substring
	 * @return bool
	 */
	public static function startsWith( $input, $substring = '' ) {
		return mb_strpos( $input, $substring ) === 0;
	}

	/**
	 * @param string $input
	 * @param string $substring
	 * @return bool
	 */
	public static function endsWith( $input, $substring ) {
		return mb_substr( $input, -mb_strlen( $substring ) ) === $substring;
	}

	/**
	 * @param string $input
	 * @param string $prefix
	 * @return string
	 */
	public static function removePrefix( $input, $prefix ) {
		if ( self::startsWith( $input, $prefix ) ) {
			return mb_substr( $input, mb_strlen( $prefix ) );
		}

		return $input;
	}

	/**
	 * @param string $input
	 * @param string $suffix
	 * @return string
	 */
	public static function removeSuffix( $input, $suffix ) {
		if ( self::endsWith( $input, $suffix ) ) {
			return mb_substr( $input, 0, mb_strlen( $input ) - mb_strlen( $suffix ) );
		}

		return $input;
	}


	/**
	 * @param $str
	 * @param $startDelimiter
	 * @param $endDelimiter
	 * @return array
	 */
	public static function getStringBetween( $str, $startDelimiter, $endDelimiter ) {
		$contents = array();
		$startDelimiterLength = strlen( $startDelimiter );
		$endDelimiterLength = strlen( $endDelimiter );
		$startFrom = $contentStart = $contentEnd = 0;
		while ( false !== ( $contentStart = strpos( $str, $startDelimiter, $startFrom ) ) ) {
			$contentStart += $startDelimiterLength;
			$contentEnd = strpos( $str, $endDelimiter, $contentStart );
			if ( false === $contentEnd ) {
				break;
			}
			$contents[] = substr( $str, $contentStart, $contentEnd - $contentStart );
			$startFrom = $contentEnd + $endDelimiterLength;
		}

		return $contents;
	}

	public static function camelCase( $string, $forceWords = false ) {
		$i = array( "-", "_" );
		if ( $forceWords ) {
			$string = mb_strtolower( $string );
		}
		$string = preg_replace( '/([a-z])([A-Z])/', "\\1 \\2", $string );
		$string = preg_replace( '@[^a-zA-Z0-9\-_ ]+@', '', $string );
		$string = str_replace( $i, ' ', $string );
		$string = str_replace( ' ', '', ucwords( strtolower( $string ) ) );
		$string = strtolower( substr( $string, 0, 1 ) ) . substr( $string, 1 );

		return $string;
	}


}