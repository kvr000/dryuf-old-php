<?php

namespace net\dryuf\tenv;


class AppTenvObject extends \net\dryuf\tenv\TenvObject implements \net\dryuf\core\AppContainerAware
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
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		$this->appContainer = $appContainer;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			createCallerContext()
	{
		return $this->appContainer->createCallerContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	protected			$appContainer;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	public function			getAppContainer()
	{
		return $this->appContainer;
	}
};


?>
