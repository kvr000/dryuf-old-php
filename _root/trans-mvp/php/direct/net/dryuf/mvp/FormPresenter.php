<?php

namespace net\dryuf\mvp;


abstract class FormPresenter extends \net\dryuf\mvp\ChildPresenter
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
	public function			performAction($action)
	{
		$formActioner = $action->formActioner();
		if (!is_null($formActioner)) {
			try {
				if (substr($formActioner, 0, strlen(".")) == ".") {
					return \net\dryuf\core\Dryuf::invokeMethod($this, \net\dryuf\core\Dryuf::getObjectMethod($this, strval(substr($formActioner, 1)), 'net\dryuf\meta\ActionDef'), $action);
				}
				else {
					$performer = \net\dryuf\core\Dryuf::createObjectArgs(\net\dryuf\core\Dryuf::loadConstructor($formActioner, 'net\dryuf\mvp\FormPresenter'), $this);
					return \net\dryuf\core\Dryuf::invokeMethod($performer, \net\dryuf\core\Dryuf::getObjectMethod($performer, "performAction", 'net\dryuf\meta\ActionDef'), $action);
				}
			}
			catch (\net\dryuf\core\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("Failed to run ".$formActioner.": ".strval($ex), $ex);
			}
		}
		throw new \net\dryuf\core\ReportException("invalid action: ".$action->name());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	initForm();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public abstract function	retrieve($errors, $action);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		foreach ($this->getActionDefs() as $action) {
			$errors = new \net\dryuf\util\php\StringNativeHashMap();
			if (is_null($this->getRequest()->getParamDefault($this->formWebPrefix.$action->name(), null)))
				continue;
			if (!$this->retrieve($errors, $action)) {
				foreach ($errors->keySet() as $key) {
					$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Error, $this->localize($this->formClassName, $key).": ".$errors->get($key));
				}
				return true;
			}
			else {
				return $this->performAction($action);
			}
		}
		$this->initForm();
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		getRequestCaptcha($request)
	{
		if (!is_null(($session = $request->getSession())))
			return $session->getAttribute('net\dryuf\mvp\FormPresenter'.".captcha");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		setRequestCaptcha($request, $captcha)
	{
		$request->forceSession()->setAttribute('net\dryuf\mvp\FormPresenter'.".captcha", $captcha);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	protected abstract function	getActionDefs();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$formClassName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$formWebPrefix;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFormWebPrefix()
	{
		return $this->formWebPrefix;
	}
};


?>
