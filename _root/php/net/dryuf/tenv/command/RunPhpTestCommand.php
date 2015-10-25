<?php

namespace net\dryuf\tenv\command;


class RunPhpTestCommand extends \net\dryuf\process\command\AbstractCommand
{
	/**
	*/
	public function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		main($arguments)
	{
		exit(\net\dryuf\process\command\ExternalCommandRunner::createFromClassPath()->runNew('net\dryuf\tenv\command\RunPhpTestCommand', $arguments));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			parseArguments($arguments)
	{
		$this->options = \net\dryuf\util\MapUtil::createHashMap(
			'R',			'net.dryuf.tenv.reporter.TapReporter'
		);
		return parent::parseArguments($arguments);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			reportUsage($reason)
	{
		return $this->commandRunner->reportUsage($reason,
			"Options: -R reporter-class class_names...\n".
			"\t-R\t\treporter-class\t\tclass to use output the report\n"
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			process()
	{
		$presenter = \net\dryuf\mvp\DummyRootPresenter::createFullyDummy($this->getCallerContext());
		$reporter = $presenter->getCallerContext()->createBeanedArgs($this->options->get("R"), array($presenter), null);

		return \net\dryuf\core\Dryuf::createClassArg2('\net\dryuf\tenv\TenvRunner', $presenter, $reporter)->runTests($this->options->get(""));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	public function			getOptionsDefinition()
	{
		return self::$optionsDefinition;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$options;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getOptions()
	{
		return $this->options;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	static				$optionsDefinition;

	public static function		_initManualStatic()
	{
		self::$optionsDefinition = (new \net\dryuf\process\command\GetOptionsStd())
			->setDefinition(\net\dryuf\util\MapUtil::createHashMap(
				'R',		'net.dryuf.logical.DotClassname'
			))
			->setMinParameters(1)
			->setMaxParameters(0x7fffffff);
	}

};

\net\dryuf\tenv\command\RunPhpTestCommand::_initManualStatic();


?>
