<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 10/21/2018
 * Time: 10:59 AM
 */

namespace Qpdb\Common\Prototypes\Traits;


use Qpdb\Common\Exceptions\PrototypeException;

trait AsStoredSettings
{
	/**
	 * @var array
	 */
	protected $__settings = [];

	/**
	 * @param $varName
	 * @param null $value
	 * @return $this
	 * @throws PrototypeException
	 */
	public function set( $varName, $value = null )
	{
		if ( gettype( $varName ) !== 'string' || empty( $varName ) ) {
			throw new PrototypeException( 'Invalid variable name in ' . self::class . '::set()' );
		}
		$this->__settings[ $varName ] = $value;

		return $this;
	}

	/**
	 * @param string $varName
	 * @return mixed
	 * @throws PrototypeException
	 */
	public function get( $varName )
	{
		if ( gettype( $varName ) !== 'string' || empty( $varName ) ) {
			throw new PrototypeException( 'Invalid variable name in ' . self::class . '::get()' );
		}

		if ( !isset( $this->__settings[ $varName ] ) ) {
			throw new PrototypeException( 'Variable  is not set in ' . self::class . '::get(' . $varName . ')' );
		}

		return $this->__settings[ $varName ];
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		return $this->__settings;
	}


}