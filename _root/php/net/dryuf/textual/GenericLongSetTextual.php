<?php

namespace net\dryuf\textual;


class GenericLongSetTextual extends \net\dryuf\textual\DirectKeyPreTrimTextual
{
	/**
	*/
	function			__construct($dataClass, $optionsMap)
	{
		parent::__construct();
		$this->dataClass = $dataClass;
		$this->optionsMap = $optionsMap;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			check($text, $style)
	{
		if (!($text === "")) {
			$pos = strlen($text);
			do {
				$newpos = \net\dryuf\core\StringUtil::lastIndexOf($text, ',', $pos-1);
				if ($newpos < 0)
					$newpos = 0;
				if (is_null($this->optionsMap->get(strval(substr($text, $newpos, $pos)))))
					return $this->getUiContext()->localize($this->dataClass, "unknown option: ").strval(substr($text, $newpos, $pos));
			} while ($pos > 0);
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			convert($text, $style)
	{
		$internal = 0;
		if (!($text === "")) {
			$pos = strlen($text);
			do {
				$newpos = \net\dryuf\core\StringUtil::lastIndexOf($text, ',', $pos-1);
				if ($newpos < 0)
					$newpos = 0;
				$internal |= 1<<$this->optionsMap->get(strval(substr($text, $newpos, $pos)));
			} while ($pos > 0);
		}
		return intval($internal);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		$max = 0;
		foreach ($this->optionsMap->values() as $option)
			$max += $option;
		if (($internal&~$max) != 0) {
			return $this->getUiContext()->localize($this->dataClass, "Invalid value passed: ").($internal&~$max);
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal_, $style)
	{
		$internal = intval($internal_);
		$text = "";
		for ($i = 0; ($internal>>$i) != 0; $i++) {
			if (($internal&(1<<$i)) != 0) {
				if (!($text === ""))
					$text = $text.",";
				$text = $text.$this->callerContext->getUiContext()->localize($this->dataClass, $this->optionsMap->keySet()->toArray(\net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY)[$i]);
			}
		}
		return $text;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			convertKeyInternal($text)
	{
		return \net\dryuf\core\Dryuf::parseInt($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dataClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\String, java\lang\Long>')
	*/
	protected			$optionsMap;
};


?>
