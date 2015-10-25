<?php

namespace net\dryuf\textual;


class TimeDateSlashedTextual extends \net\dryuf\textual\FormatOnlyTextual
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
	public function			format($internal, $style)
	{
		return date('H:i:s d/m/Y', $internal/1000);
	}
};


?>
