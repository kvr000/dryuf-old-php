<?php

namespace net\dryuf\textual;


class UtcDateTimeTextual extends \net\dryuf\textual\DateTimeBaseTextual
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
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^(\\d{1,2})\\s*\\.\\s*(\\d{1,2})\\s*\\.\\s*(\\d{4})\\s+(\\d{1,2}):(\\d{1,2}):(\\d{1,2})\$", $text)))) {
			if (!is_null($this->checkDatetimeValid(\net\dryuf\core\Dryuf::parseInt($groups[3]), \net\dryuf\core\Dryuf::parseInt($groups[2])-1, \net\dryuf\core\Dryuf::parseInt($groups[1])-1, \net\dryuf\core\Dryuf::parseInt($groups[4]), \net\dryuf\core\Dryuf::parseInt($groups[5]), \net\dryuf\core\Dryuf::parseInt($groups[6]))))
				return null;
		}
		else {
			if (!is_null(\net\dryuf\core\StringUtil::matchText("^epoch:\\s*(\\d+)\$", $text)))
				return null;
		}
		return $this->getErrorMessage();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			convert($text, $style)
	{
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^(\\d{1,2})\\s*\\.\\s*(\\d{1,2})\\s*\\.\\s*(\\d{4})\\s+(\\d{1,2}):(\\d{1,2}):(\\d{1,2})\$", $text)))) {
			if (!is_null(($internal = $this->checkDatetimeValid(\net\dryuf\core\Dryuf::parseInt($groups[3]), \net\dryuf\core\Dryuf::parseInt($groups[2])-1, \net\dryuf\core\Dryuf::parseInt($groups[1])-1, \net\dryuf\core\Dryuf::parseInt($groups[4]), \net\dryuf\core\Dryuf::parseInt($groups[5]), \net\dryuf\core\Dryuf::parseInt($groups[6])))))
				return $internal;
		}
		elseif (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^epoch:\\s*(\\d+)\$", $text)))) {
			return \net\dryuf\core\Dryuf::parseInt($groups[1])*1000;
		}
		throw new \net\dryuf\core\RuntimeException("Invalid format for date, no check performed?");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return (new \java\text\SimpleDateFormat("dd.MM.yyyy HH:mm:ss"))->format((=f_I_x=)new java.util.Date(((java.lang.Long)internal).longValue())(=x_I_f=));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	protected function		checkDatetimeValid($year, $month, $day, $hour, $minute, $second)
	{
		try {
			return (gmmktime($hour, $minute, $second, $month+1, $day+1, $year-1900)*1000);
		}
		catch (\net\dryuf\core\Exception $ex) {
			return null;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getErrorMessage()
	{
		return $this->getUiContext()->localize('net\dryuf\textual\DateTimeTextual', "Format dd.mm.yyyy hh:mm:ss required");
	}
};


?>
