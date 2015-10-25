<?php

namespace net\dryuf\textual;


class DateTimeDashedSpacedTextual extends \net\dryuf\textual\FormatOnlyTextual
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
		return date('Y-m-d H:i:s', $internal/1000);
	}
};


?>
