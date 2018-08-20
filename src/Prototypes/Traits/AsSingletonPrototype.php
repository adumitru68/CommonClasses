<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 8/20/2018
 * Time: 11:07 PM
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