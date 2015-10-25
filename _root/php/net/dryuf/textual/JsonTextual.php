<?php

namespace net\dryuf\textual;


class JsonTextual extends \net\dryuf\textual\TextTextual
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
		return json_decode($text) !== false ? null : $this->uiContext->localize("dryuf::textual::Json", "Invalid json content");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			convert($text, $style)
	{
		return json_decode($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return json_encode($internal);
	}
};


?>
