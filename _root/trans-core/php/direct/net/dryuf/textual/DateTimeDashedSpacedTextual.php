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
		return (new \java\text\SimpleDateFormat("yyyy-MM-dd' 'HH:mm:ss"))->format((=f_I_x=)new java.util.Date(((java.lang.Long)internal))(=x_I_f=));
	}
};


?>
