<?php

namespace net\dryuf\textual;


class NaturalTextual extends \net\dryuf\textual\IntegerTextual
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
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\NaturalTextual', "Natural number required.");
		return null;
	}
};


?>
