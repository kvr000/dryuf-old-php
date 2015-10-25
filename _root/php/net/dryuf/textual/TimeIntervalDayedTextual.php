<?php

namespace net\dryuf\textual;


class TimeIntervalDayedTextual extends \net\dryuf\textual\FormatOnlyTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal_, $style)
	{
		$internal = intval($internal_/1000);
		$sec = $internal%60;
		$internal = intval($internal/60);
		$min = $internal%60;
		$internal = intval($internal/60);
		$hour = $internal%24;
		$days = intval($internal/24);
		return sprintf("%dd %02d:%02d:%02d", $days, $hour, $min, $sec);
	}
};


?>
