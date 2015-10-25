<?php

namespace net\dryuf\textual;


class ConfirmSwitchTextual extends \net\dryuf\textual\BoolSwitchTextual
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
	public function			check($text, $style)
	{
		if (!is_null(($err = parent::check($text, $style))))
			return $err;
		if (!parent::convertInternal($text, $style))
			return $this->getUiContext()->localize('net\dryuf\textual\ConfirmSwitchTextual', "Confirmation required");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if (!is_null(($error = parent::validate($internal))))
			return $error;
		if (!$internal)
			return $this->getUiContext()->localize('net\dryuf\textual\ConfirmSwitchTextual', "Confirmation required");
		return null;
	}
};


?>
