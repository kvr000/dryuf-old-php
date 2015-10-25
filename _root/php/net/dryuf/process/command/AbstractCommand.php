<?php

namespace net\dryuf\process\command;


abstract class AbstractCommand extends \net\dryuf\core\Object implements \net\dryuf\process\command\Command
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCommandRunner($commandRunner)
	{
		$this->commandRunner = $commandRunner;
		$this->callerContext = $commandRunner->getCallerContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	protected abstract function	getOptionsDefinition();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected abstract function	getOptions();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		validateArguments()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkOptionHelp()
	{
		return $this->getOptions()->containsKey("h");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			parseArguments($args)
	{
		if (!is_null(($error = $this->getOptionsDefinition()->parseArguments($this->getCallerContext(), $this->getOptions(), $args))))
			return $error;
		if (!is_null(($error = $this->validateArguments())))
			return $error;
		return $this->checkOptionHelp() ? "" : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			reportUsage($reason)
	{
		return ($reason === "") ? 0 : 127;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	protected function		getUiContext()
	{
		return $this->getCallerContext()->getUiContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\CommandRunner')
	*/
	protected			$commandRunner;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\CommandRunner')
	*/
	public function			getCommandRunner()
	{
		return $this->commandRunner;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->callerContext;
	}
};


?>
