<?php

namespace net\dryuf\textual;


class TimeIntervalTextual extends \net\dryuf\textual\ConvertRegexpTextual
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
		if (!is_null(\net\dryuf\core\StringUtil::matchText("^(((\\d+):)?((\\d+):))?(\\d+)\\s*s?\$", $text))) {
			return null;
		}
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\TimeIntervalTextual', "hour:min:sec required");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			convertInternal($text, $style)
	{
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^(((\\d+):)?((\\d+):))?(\\d+)\\s*s?\$", $text)))) {
			return (1000*((is_null($groups[2]) ? 0 : \net\dryuf\core\Dryuf::parseInt($groups[3])*3600)+(is_null($groups[4]) ? 0 : \net\dryuf\core\Dryuf::parseInt($groups[5])*60)+\net\dryuf\core\Dryuf::parseInt($groups[6])*1));
		}
		throw new \net\dryuf\core\RuntimeException("invalid format for time interval, no check performed?");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal_, $style)
	{
		$internal = intval($internal_/1000);
		$sec = $internal%60;
		$internal = intval($internal/60);
		$min = $internal%60;
		$internal = intval($internal/60);
		$hour = $internal;
		return sprintf("%d:%02d:%02d s", $hour, $min, $sec);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		return is_int($internal) ? null : $this->callerContext->getUiContext()->localize('net\dryuf\textual\TimeIntervalTextual', "Number required.");
	}
};


?>
