<?php

namespace net\dryuf\textual;


class LatitudeBaseTextual extends \net\dryuf\textual\DirectKeyPreTrimTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			convertKeyInternal($text)
	{
		return \net\dryuf\core\Dryuf::parseInt($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validateDouble($value)
	{
		if ($value < -900000000 || $value > 900000000)
			return $this->getUiContext()->localize('net\dryuf\textual\LatitudeTextual', "latitude must be within interval -90 - 90");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if ($internal < -900000000 || $internal > 900000000)
			return $this->getUiContext()->localize('net\dryuf\textual\LatitudeTextual', "latitude must be within interval -90 - 90");
		return null;
	}
};


?>
