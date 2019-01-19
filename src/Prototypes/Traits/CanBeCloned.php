<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 1/12/2019
 * Time: 4:27 AM
 */

namespace Qpdb\Common\Prototypes\Traits;


trait CanBeCloned
{
	/**
	 * @return $this
	 */
	public function getClone() {
		return clone $this;
	}

}