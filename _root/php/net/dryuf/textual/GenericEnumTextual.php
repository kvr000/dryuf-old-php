<?php

namespace net\dryuf\textual;


class GenericEnumTextual extends \net\dryuf\textual\DirectKeyPreTrimTextual
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
		if (is_null($this->optionsMap->get($text)))
			return $this->getUiContext()->localize($this->dataClass, "Invalid option, allowed only defined values: ").\net\dryuf\core\StringUtil::join(", ", $this->optionsMap->keySet());
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			convertInternal($text, $style)
	{
		if (is_null($this->optionsMap->get($text)))
			throw new \net\dryuf\core\RuntimeException("Invalid option, allowed only defined values for ".$this->dataClass.": ".\net\dryuf\core\StringUtil::join(", ", $this->optionsMap->keySet()));
		$internal = $this->optionsMap->get($text);
		return $internal;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if ($internal < 0 || $internal >= $this->optionsMap->size())
			return $this->getUiContext()->localize($this->dataClass, "Invalid option, allowed only defined values ");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return $this->callerContext->getUiContext()->localize($this->dataClass, $this->optionsMap->keySet()->toArray(\net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY)[$internal]);
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
	protected			$dataClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\String, java\lang\Integer>')
	*/
	protected			$optionsMap;
};


?>
