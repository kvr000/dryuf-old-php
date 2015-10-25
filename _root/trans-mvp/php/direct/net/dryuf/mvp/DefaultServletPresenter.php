<?php

namespace net\dryuf\mvp;


class DefaultServletPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public static function		createSafeAndProcess($parentPresenter)
	{
		$this_ = new \net\dryuf\mvp\DefaultServletPresenter($parentPresenter, \net\dryuf\core\Options::$NONE);
		return $this_->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return $this->processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$this->getRootPresenter()->setLeadChild($this);
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		try {
			$webRequest = $this->rootPresenter->getRequest();
			$defaultHandler = new \org\springframework\web\servlet\resource\DefaultServletHttpRequestHandler();
			$defaultHandler->setServletContext($webRequest->getServletContext());
			$defaultHandler->handleRequest($webRequest->getServletRequest(), $webRequest->getServletResponse());
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}
};


?>
