<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 10/21/2018
 * Time: 10:54 AM
 */

namespace Qpdb\Common\Prototypes\Traits;


trait AsSingletonPrototype
{

	protected static $instance;

	/**
	 * @return $this
	 */
	public static function getInstance()
	{
		if ( is_null( self::$instance ) )
			self::$instance = new self();

		return self::$instance;
	}

}