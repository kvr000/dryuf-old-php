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
				if ($formActioner[0] == ".") {
					$method = substr($formActioner, 1);
					return $this->$method($action);
				}
				else {
					return \net\dryuf\core\Dryuf::createClassArg1($formActioner, $this)->performAction($action);
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
