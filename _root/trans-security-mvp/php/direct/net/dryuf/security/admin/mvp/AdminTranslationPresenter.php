<?php

namespace net\dryuf\security\admin\mvp;


class AdminTranslationPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct(\net\dryuf\mvp\Presenter $parentPresenter, \net\dryuf\core\Options $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		$this->authenticationFrontend = $this->getCallerContext()->getBeanTyped("authenticationFrontend", 'net\dryuf\security\web\AuthenticationFrontend');
		return parent::processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\admin\form\AdminTranslationForm')
	*/
	public function			createBackingObject()
	{
		return new \net\dryuf\security\admin\form\AdminTranslationForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			initData()
	{
		$session = $this->getRootPresenter()->getSession();
		if (!is_null($session)) {
			$this->getBackingObject()->setTranslationLevel($this->getUiContext()->getLocalizeDebug());
			$this->getBackingObject()->setTiming($this->getUiContext()->getTiming());
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performUpdate($action)
	{
		$rootPresenter = $this->getRootPresenter();
		$rootPresenter->getUiContext()->setLocalizeDebug($this->getBackingObject()->getTranslationLevel());
		$this->authenticationFrontend->setTranslationLevel($this->getPageContext(), $this->getBackingObject()->getTranslationLevel());
		$this->authenticationFrontend->setTiming($this->getPageContext(), $this->getBackingObject()->getTiming());
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->output("<div class=\"page-key\">Current translation set up:</div>");
		parent::render();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\web\AuthenticationFrontend')
	*/
	protected			$authenticationFrontend;
};


?>
