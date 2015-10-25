<?php

namespace net\dryuf\textual;


class MoneyTextual extends \net\dryuf\textual\DoubleTextual
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
		return sprintf("%.3f", $internal);
	}
};


?>
