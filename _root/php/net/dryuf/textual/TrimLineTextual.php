<?php

namespace net\dryuf\textual;


class TrimLineTextual extends \net\dryuf\textual\TrimTextual
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
	public function			validate($internal)
	{
		if (\net\dryuf\core\StringUtil::indexOf($internal, "\n") >= 0) {
			return $this->getUiContext()->localize('net\dryuf\textual\TrimLineTextual', "Singled line required.");
		}
		return null;
	}
};


?>
