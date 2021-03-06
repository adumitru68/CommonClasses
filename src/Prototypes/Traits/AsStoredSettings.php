<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 10/21/2018
 * Time: 10:59 AM
 */

namespace Qpdb\Common\Prototypes\Traits;


use Qpdb\Common\Exceptions\CommonException;

trait AsStoredSettings
{
	/**
	 * @var array
	 */
	protected $__prototype_stored_settings_vars = [];

	/**
	 * @param $varName
	 * @param null $value
	 * @return $this
	 * @throws CommonException
	 */
	public function set( $varName, $value = null )
	{
		if ( gettype( $varName ) !== 'string' || empty( $varName ) ) {
			throw new CommonException( 'Invalid variable name in ' . self::class . '::set()' );
		}
		$this->__prototype_stored_settings_vars[ $varName ] = $value;

		return $this;
	}

	/**
	 * @param string $varName
	 * @return mixed
	 * @throws CommonException
	 */
	public function get( $varName )
	{
		if ( gettype( $varName ) !== 'string' || empty( $varName ) ) {
			throw new CommonException( 'Invalid variable name in ' . self::class . '::get()' );
		}

		if ( !isset( $this->__prototype_stored_settings_vars[ $varName ] ) ) {
			throw new CommonException( 'Variable is not set in ' . self::class . '::get(' . $varName . ')' );
		}

		return $this->__prototype_stored_settings_vars[ $varName ];
	}

	/**
	 * @return array
	 */
	public function getStoredData() {
		return $this->__prototype_stored_settings_vars;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function withStoredData( array $data ) {
		$this->__prototype_stored_settings_vars = $data;

		return $this;
	}

}