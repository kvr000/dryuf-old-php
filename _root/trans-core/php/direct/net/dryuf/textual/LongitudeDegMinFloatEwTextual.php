<?php

namespace net\dryuf\textual;


class LongitudeDegMinFloatEwTextual extends \net\dryuf\textual\FormatOnlyTextual
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
		$internal = intval($internal_);
		$internal /= 1.0E7;
		$deg = intval(floor($internal));
		$min = ($internal-$deg)*60;
		return sprintf("%d %.3f %c", $deg, $min, $internal >= 0 ? 'E' : 'W');
	}
};


?>
