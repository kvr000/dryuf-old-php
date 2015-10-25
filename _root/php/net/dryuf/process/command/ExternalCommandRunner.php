<?php

namespace net\dryuf\process\command;


class ExternalCommandRunner extends \net\dryuf\process\command\AbstractCommandRunner
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\ExternalCommandRunner')
	*/
	public static function		createFromClassPath()
	{
		$appContainer = \net\dryuf\mvp\php\PhpContextManager::createAppContainer();
		return new \net\dryuf\process\command\ExternalCommandRunner($appContainer->createCallerContext());
	}

	/**
	*/
	function			__construct($callerContext)
	{
		parent::__construct($callerContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			reportUsage($error, $usage)
	{
		if (($error === "")) {
			fputs(STDOUT, $usage);
		}
		else {
			fputs(STDERR, $error);
			if (!is_null($usage))
				fputs(STDOUT, $usage);
		}
		return 126;
	}
};


?>
