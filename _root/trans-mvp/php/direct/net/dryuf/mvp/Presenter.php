<?php

namespace net\dryuf\mvp;


abstract class Presenter extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MSG_Fatal = 100;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MSG_Error = 200;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MSG_Warning = 300;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MSG_Info = 400;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MSG_Debug = 500;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MSG_Trace = 600;

	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public static function		createSubPresenter($clazz, $parentPresenter, $options)
	{
		try {
			$presenter = (=f_I_x=)clazz.getConstructor(Presenter.class, Options.class)(=x_I_f=)->newInstance($parentPresenter, $options);
			$presenter->init();
			return $presenter;
		}
		catch (\net\dryuf\core\RuntimeException $e) {
			throw $e;
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public static function		callInit($presenter)
	{
		return $presenter->init();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			init()
	{
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\RootPresenter')
	*/
	public abstract function	getRootPresenter();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	public abstract function	getPageContext();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	output($text);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	outputFormat($fmt, $args);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	getLanguage();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public abstract function	getCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	setCallerContext($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Request')
	*/
	public abstract function	getRequest();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	public abstract function	getResponse();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	localize($class_name, $text);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	localizeArgs($class_name, $text, $args);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	addMessage($messageLevel, $message);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	addMessageLocalized($messageLevel, $classname, $message);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	setTitle($title);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	public abstract function	getUiContext();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public abstract function	createNotFoundPresenter();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public abstract function	createDeniedPresenter();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public abstract function	createUnallowedMethodPresenter();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public abstract function	createDefaultPresenter();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		if (!is_null($this->leadChild)) {
			return $this->leadChild->process();
		}
		elseif (!is_null(($element = $this->getRootPresenter()->getPathElement()))) {
			return $this->processMore($element);
		}
		else {
			return $this->processFinal();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public abstract function	processMore($element);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public abstract function	processFinal();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			close()
	{
		if (!is_null($this->leadChild))
			$this->leadChild->close();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		if (!is_null($this->leadChild))
			$this->leadChild->prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if (!is_null($this->leadChild))
			$this->leadChild->render();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			renderLeadChild()
	{
		if (is_null($this->leadChild))
			return false;
		$this->leadChild->render();
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			getLeadChild()
	{
		return $this->leadChild;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLeadChild($leadChild_)
	{
		$this->leadChild = $leadChild_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	protected			$leadChild = null;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;
};


?>
