<?php

namespace net\dryuf\textual;


class NaturalLongTextual extends \net\dryuf\textual\LongTextual
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
		if (!is_null(($err = parent::validate($internal))))
			return $err;
		if ($internal < 0)
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\NaturalLongTextual', "Natural long number required.");
		return null;
	}
};


?>
