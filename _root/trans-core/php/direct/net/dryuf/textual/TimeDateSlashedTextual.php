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
		return (new \java\text\SimpleDateFormat("HH:mm:ss' 'dd/MM/yyyy"))->format((=f_I_x=)new java.util.Date(internal.longValue())(=x_I_f=));
	}
};


?>
