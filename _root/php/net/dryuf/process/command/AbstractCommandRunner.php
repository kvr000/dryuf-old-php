<?php

namespace net\dryuf\process\command;


abstract class AbstractCommandRunner extends \net\dryuf\core\Object implements \net\dryuf\process\command\CommandRunner
{
	/**
	*/
	function			__construct($callerContext)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			run($command, $arguments)
	{
		$command->setCommandRunner($this);
		if (!is_null(($err = $command->parseArguments($arguments))))
			return $command->reportUsage(!($err === "") ? $err."\n" : $err);
		return $command->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			runNew($commandClass, $arguments)
	{
		try {
			$command = $this->getCallerContext()->createBeaned($commandClass, null);
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		return $this->run($command, $arguments);
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

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCallerContext($callerContext_)
	{
		$this->callerContext = $callerContext_;
	}
};


?>
