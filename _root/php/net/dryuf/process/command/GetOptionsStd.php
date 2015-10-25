<?php

namespace net\dryuf\process\command;


class GetOptionsStd extends \net\dryuf\core\Object implements \net\dryuf\process\command\GetOptions
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptionsStd')
	*/
	public function			setDefinition($map)
	{
		$this->optionsDefinition = $map;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptionsStd')
	*/
	public function			setMandatories($mandatories)
	{
		$this->mandatories = $mandatories;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptionsStd')
	*/
	public function			setMinParameters($minParameters)
	{
		$this->minParameters = $minParameters;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptionsStd')
	*/
	public function			setMaxParameters($maxParameters)
	{
		$this->maxParameters = $maxParameters;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			parseArguments($callerContext, $options, $args)
	{
		if (is_null($this->optionsDefinition))
			$this->optionsDefinition = new \net\dryuf\util\php\StringNativeHashMap();
		if (is_null($this->mandatories))
			$this->mandatories = new \net\dryuf\util\php\StringNativeHashSet();
		$appeared = new \net\dryuf\util\php\StringNativeHashSet();
		for ($i = 0; $i < count($args); $i++) {
			if (substr($args[$i], 0, strlen("-")) == "-") {
				if (($args[$i] === "--")) {
					$i++;
					break;
				}
				if (($args[$i] === "-"))
					return "missing option string: ".$args[$i]."\n";
				$option = strval(substr($args[$i], 1));
				if (!$this->optionsDefinition->containsKey($option))
					return "unknown argument: ".$option."\n";
				if ($appeared->contains($option))
					return "option ".$option." already specified\n";
				$textualClassName = $this->optionsDefinition->get($option);
				if (is_null($textualClassName)) {
					$options->put($option, true);
				}
				else {
					try {
						$textualClass = $textualClassName;
						$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($textualClass, $callerContext);
					}
					catch (\net\dryuf\core\ClassNotFoundException $e) {
						throw new \net\dryuf\core\RuntimeException($e);
					}
					if (++$i >= count($args))
						return "option ".$args[$i-1]." expects a value\n";
					$value = $textual->prepare($args[$i], null);
					if (!is_null(($error = $textual->check($value, null))))
						return "invalid option value for ".$args[$i].": ".$error."\n";
					$options->put($option, $textual->convert($value, null));
				}
				$appeared->add($option);
			}
			else {
				break;
			}
		}
		foreach ($this->mandatories as $name) {
			if (!$appeared->contains($name))
				return "Option ".$name." is mandatory\n";
		}
		if (count($args)-$i < $this->minParameters)
			return "Expected at least ".$this->maxParameters." arguments\n";
		if (count($args)-$i > $this->maxParameters)
			return "Expected at most ".$this->maxParameters." arguments\n";
		$options->put("", array_slice($args, $i, count($args)-$i));
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$minParameters = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$maxParameters = 0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$optionsDefinition;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	protected			$mandatories;
};


?>
