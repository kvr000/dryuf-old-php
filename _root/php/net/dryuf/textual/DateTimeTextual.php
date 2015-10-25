<?php

namespace net\dryuf\textual;


class DateTimeTextual extends \net\dryuf\textual\DateTimeBaseTextual
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
	public function			convertInternal($text, $style)
	{
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^(\\d{1,2})\\s*\\.\\s*(\\d{1,2})\\s*\\.\\s*(\\d{4})\\s+(\\d{1,2}):(\\d{1,2}):(\\d{1,2})\$", $text)))) {
			if (!is_null(($internal = $this->checkDatetimeValid(\net\dryuf\core\Dryuf::parseInt($groups[3]), \net\dryuf\core\Dryuf::parseInt($groups[2])-1, \net\dryuf\core\Dryuf::parseInt($groups[1])-1, \net\dryuf\core\Dryuf::parseInt($groups[4]), \net\dryuf\core\Dryuf::parseInt($groups[5]), \net\dryuf\core\Dryuf::parseInt($groups[6])))))
				return $internal;
		}
		elseif (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^epoch:\\s*(\\d+)\$", $text)))) {
			return \net\dryuf\core\Dryuf::parseInt($groups[1]);
		}
		throw new \net\dryuf\core\RuntimeException($this->getErrorMessage());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return date('d.m.Y H:i:s', int($internal/1000));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	protected function		checkDatetimeValid($year, $month, $day, $hour, $minute, $second)
	{
		try {
			return \net\dryuf\core\Dryuf::multiply1000(mktime(0, 0, 0, $month+1, $day+1, $year));
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
		return $this->callerContext->getUiContext()->localize("net.dryuf.textual.DateTime", "format dd.mm.yyyy hh:mm:ss required");
	}
};


?>
