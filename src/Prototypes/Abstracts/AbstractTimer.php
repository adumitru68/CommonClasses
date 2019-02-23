<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/23/2019
 * Time: 10:46 AM
 */

namespace Qpdb\Common\Prototypes\Abstracts;


class AbstractTimer
{

	/**
	 * @var float
	 */
	protected $timeStart;

	/**
	 * AbstractTimer constructor.
	 * @param null|float $time
	 */
	public function __construct( $time = null ) {
		$this->timeStart = $time ?: microtime( true );
	}

	/**
	 * @param bool $incrementTimeStart
	 * @return float|mixed
	 */
	public function getDuration( $incrementTimeStart = false ) {
		$time = microtime( true );
		$duration = $time - $this->timeStart;
		if($incrementTimeStart) {
			$this->timeStart = $time;
		}

		return $duration;
	}


}