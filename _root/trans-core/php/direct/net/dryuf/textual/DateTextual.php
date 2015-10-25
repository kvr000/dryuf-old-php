<?php

namespace net\dryuf\textual;


class DateTextual extends \net\dryuf\textual\DateTimeBaseTextual
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
		if (is_null(($groups = \net\dryuf\core\StringUtil::matchText("^(\\d{1,2})\\s*\\.\\s*(\\d{1,2})\\s*\\.\\s*(\\d{4})\$", $text))))
			return $this->getErrorMessage();
		if (is_null($this->checkDateValid(\net\dryuf\core\Dryuf::parseInt($groups[3]), \net\dryuf\core\Dryuf::parseInt($groups[2])-1, \net\dryuf\core\Dryuf::parseInt($groups[1])-1)))
			return $this->getErrorMessage();
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			convertInternal($text, $style)
	{
		if (is_null(($groups = \net\dryuf\core\StringUtil::matchText("^(\\d{1,2})\\s*\\.\\s*(\\d{1,2})\\s*\\.\\s*(\\d{4})\$", $text)))) {
			throw new \net\dryuf\core\RuntimeException($this->getErrorMessage());
		}
		if (is_null(($internal = $this->checkDateValid(\net\dryuf\core\Dryuf::parseInt($groups[3]), \net\dryuf\core\Dryuf::parseInt($groups[2])-1, \net\dryuf\core\Dryuf::parseInt($groups[1])-1))))
			throw new \net\dryuf\core\RuntimeException($this->getErrorMessage());
		return $internal;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return (new \java\text\SimpleDateFormat("dd.MM.yyyy"))->format((=f_I_x=)new java.util.Date(((java.lang.Long)internal))(=x_I_f=));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	protected function		checkDateValid($year, $month, $day)
	{
		try {
			return (gmmktime(0, 0, 0, $month+1, $day+1, $year-1900)*1000);
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
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\DateTextual', "format dd.mm.yyyy required");
	}
};


?>
