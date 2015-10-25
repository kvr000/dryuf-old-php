<?php

namespace net\dryuf\security\command;


class CreateUserCommand extends \net\dryuf\process\command\AbstractCommand
{
	/**
	*/
	function			__construct()
	{
		$this->actions = new \net\dryuf\util\LinkedList();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			main($arguments)
	{
		exit(\net\dryuf\process\command\ExternalCommandRunner::createFromClassPath()->runNew('net\dryuf\security\command\CreateUserCommand', $arguments));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			parseArguments($arguments)
	{
		$this->options = new \net\dryuf\util\php\StringNativeHashMap();
		return parent::parseArguments($arguments);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			reportUsage($reason)
	{
		return $this->commandRunner->reportUsage($reason, "Options: [-h] username password email\n\t-h\t\tprint this help\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			process()
	{
		$parameters = $this->options->get("");
		$username = $parameters[0];
		$email = $parameters[1];
		$password = $parameters[2];
		$userAccount = new \net\dryuf\security\UserAccount();
		$userAccount->setUsername($username);
		$userAccount->setActivated(true);
		$userAccount->setEmail($email);
		if (($error = $this->userAccountBo->createUser($userAccount, $password)) == 0) {
			fputs(STDERR, 
				$this->getCallerContext()->getUiContext()->localizeArgs('net\dryuf\security\command\CreateUserCommand', "User {0} created, userId={1}\n", 
					array(
						$userAccount->getUsername(),
						$userAccount->getUserId()
					)));
			return 1;
		}
		else {
			fputs(STDERR, "Error occurred: ".$this->userAccountBo->formatError($this->getCallerContext()->getUiContext(), $error)."\n");
			return 0;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Integer>')
	*/
	protected			$actions;

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
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	@\javax\inject\Inject
	*/
	protected			$userAccountBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	public function			getOptionsDefinition()
	{
		return self::$optionsDefinition;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	static				$optionsDefinition;

	public static function		_initManualStatic()
	{
		self::$optionsDefinition = (new \net\dryuf\process\command\GetOptionsStd())->setMinParameters(3)->setMaxParameters(3);
	}

};

\net\dryuf\security\command\CreateUserCommand::_initManualStatic();


?>
