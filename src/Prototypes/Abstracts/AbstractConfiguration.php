<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/24/2019
 * Time: 9:31 AM
 */

namespace Qpdb\Common\Prototypes\Abstracts;


use Qpdb\Common\Exceptions\CommonException;

abstract class AbstractConfiguration
{

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * AbstractConfiguration constructor.
	 * @param null $configOptions
	 * @throws CommonException
	 */
	public function __construct( $configOptions = null ) {
		if ( null !== $configOptions ) {
			if ( is_string( $configOptions ) ) {
				$this->setConfigPath( $configOptions );
			} elseif ( is_array( $configOptions ) ) {
				$this->setConfigByArray( $configOptions );
			} else {
				throw new CommonException('Invalid configuration input');
			}
		}
	}

	/**
	 * @param array $arrayOptions
	 * @return $this
	 */
	public function setConfigByArray( array $arrayOptions ) {
		$this->config = $arrayOptions;

		return $this;
	}

	/**
	 * @param $path
	 * @return $this
	 * @throws CommonException
	 */
	public function setConfigPath( $path ) {
		if ( !file_exists( $path ) ) {
			throw new CommonException( 'Invalid path configuration' );
		}
		/** @noinspection PhpIncludeInspection */
		$this->config = require $path;

		return $this;
	}

	/**
	 * @param string $propertyName
	 * @return mixed
	 * @throws CommonException
	 */
	public function getProperty( $propertyName ) {
		$propertyNameArray = explode( '.', $propertyName );
		$cursor = $this->config;
		$recursiveProperties = [];
		foreach ( $propertyNameArray as $key ) {
			$recursiveProperties[] = $key;
			if ( is_array( $cursor ) ) {
				if ( array_key_exists( $key, $cursor ) ) {
					$cursor = $cursor[ $key ];
				} else {
					throw new CommonException( 'Property ' . implode( '.', $recursiveProperties ) . ' is not found!');
				}
			} else {
				return $cursor[ $key ];
			}
		}

		return $cursor;
	}


}