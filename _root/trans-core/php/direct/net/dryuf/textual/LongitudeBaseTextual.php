<?php

namespace net\dryuf\textual;


class LongitudeBaseTextual extends \net\dryuf\textual\DirectKeyPreTrimTextual
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
		if ($value < -1800000000 || $value > 1800000000)
			return $this->getUiContext()->localize('net\dryuf\textual\LongitudeTextual', "Longitude must be within interval -180 - 180");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if ($internal < -1800000000 || $internal > 1800000000)
			return $this->getUiContext()->localize('net\dryuf\textual\LongitudeTextual', "Longitude must be within interval -180 - 180");
		return null;
	}
};


?>
