<?php

namespace net\dryuf\textual;


class LongitudeTextual extends \net\dryuf\textual\LongitudeBaseTextual
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
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^((W|E)\\s*(\\d{1,2})°\\s*(\\d{1,2})\\'\\s*(\\d{1,2}(\\.\\d*)?)\\\"|[+-]?\\d+\\.\\d*)\$", $text)))) {
			if (!is_null($groups[3])) {
				$lng = \net\dryuf\core\Dryuf::parseInt($groups[3])+\net\dryuf\core\Dryuf::parseFloat($groups[4])/60+\net\dryuf\core\Dryuf::parseFloat($groups[5])/3600;
				if (($groups[2] === "W"))
					$lng = -$lng;
			}
			else {
				throw new \net\dryuf\core\RuntimeException("todo");
			}
			return $this->validateDouble($lng*10000000);
		}
		else {
			return $this->callerContext->getUiContext()->localize("net.dryuf.textual.Latitude", "format N|S dd°mm'ss[.sss]\" required");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			convertInternal($text, $style)
	{
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^((W|E)\\s*(\\d{1,2})°\\s*(\\d{1,2})\\'\\s*(\\d{1,2}(\\.\\d*)?)\\\"|[+-]?\\d+\\.\\d*)\$", $text)))) {
			$lng = \net\dryuf\core\Dryuf::parseInt($groups[3])+\net\dryuf\core\Dryuf::parseFloat($groups[4])/60+\net\dryuf\core\Dryuf::parseFloat($groups[5])/3600;
			if (($groups[2] === "W"))
				$lng = -$lng;
			$lng *= 10000000;
			if (!is_null(($error = $this->validateDouble($lng))))
				throw new \net\dryuf\core\RuntimeException($error);
			return intval(intval($lng));
		}
		else {
			throw new \net\dryuf\core\RuntimeException("invalid format for longitude, no check performed?");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal_, $style)
	{
		$internal = intval($internal_);
		$orient = $internal < 0 ? 'S' : 'N';
		if ($internal < 0)
			$internal = -$internal;
		$degree = intval($internal/10000000);
		$internal -= $degree*10000000;
		$min = intval($internal*60/10000000);
		$internal -= intval($min*10000000/60);
		$sec = $internal*3600/1.0E7;
		return sprintf("%c%d°%d'%.3f\"", $orient, $degree, $min, $sec);
	}
};


?>
