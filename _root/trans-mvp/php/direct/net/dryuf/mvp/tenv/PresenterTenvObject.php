<?php

namespace net\dryuf\mvp\tenv;


class PresenterTenvObject extends \net\dryuf\tenv\AppTenvObject implements \net\dryuf\core\AppContainerAware
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
		parent::afterAppContainer($appContainer);
		$this->callerContext = $appContainer->createCallerContext();
		$this->uiContext = $this->callerContext->getUiContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\RootPresenter')
	*/
	public function			createRootPresenter()
	{
		$this->mockRequest = new \net\dryuf\srvui\mock\MockRequest($this->callerContext);
		return new \net\dryuf\mvp\DummyRootPresenter($this->callerContext, $this->mockRequest);
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			runGetBytes($presenter)
	{
		$rootPresenter = $presenter->getRootPresenter();
		$rootPresenter->run();
		return $rootPresenter->getOutput();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			runGetString($presenter)
	{
		$rootPresenter = $presenter->getRootPresenter();
		$rootPresenter->run();
		return ($rootPresenter->getOutput());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public				$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	public				$uiContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	public function			getUiContext()
	{
		return $this->uiContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\mock\MockRequest')
	*/
	public				$mockRequest;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\mock\MockRequest')
	*/
	public function			getMockRequest()
	{
		return $this->mockRequest;
	}
};


?>
