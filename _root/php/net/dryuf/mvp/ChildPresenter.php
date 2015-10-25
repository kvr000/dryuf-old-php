<?php

namespace net\dryuf\mvp;


class ChildPresenter extends \net\dryuf\mvp\Presenter
{
	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		parent::__construct();
		if (!(!is_null($parentPresenter_))) throw new \net\dryuf\core\RuntimeException("assert");
		$this->parentPresenter = $parentPresenter_;
		$this->rootPresenter = $this->parentPresenter->getRootPresenter();
		if (!$options->getOptionDefault("nolead", false))
			$this->parentPresenter->setLeadChild($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		$this->getRootPresenter()->putBackLastElement();
		return $this->createDefaultPresenter()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		switch ($this->getRequest()->getMethod()) {
		case "HEAD":
			return $this->processHead();

		case "GET":
			return $this->processGet();

		case "POST":
			return $this->processPost();

		case "PUT":
			return $this->processPut();

		case "PATCH":
			return $this->processPatch();

		case "DELETE":
			return $this->processDelete();

		case "OPTIONS":
			return $this->processOptions();

		case "TRACE":
			return $this->processTrace();

		default:
			return $this->processOther();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processSpecial()
	{
		return $this->createUnallowedMethodPresenter()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processHead()
	{
		return $this->processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processGet()
	{
		return $this->processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processPost()
	{
		return $this->processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processPut()
	{
		return $this->processSpecial();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processPatch()
	{
		return $this->processSpecial();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processDelete()
	{
		return $this->processSpecial();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processTrace()
	{
		return $this->processSpecial();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processOptions()
	{
		return $this->processSpecial();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processOther()
	{
		return $this->createUnallowedMethodPresenter()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	public function			getUiContext()
	{
		return $this->rootPresenter->getUiContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		if (is_null($this->callerContext))
			$this->callerContext = $this->parentPresenter->getCallerContext();
		return $this->callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Request')
	*/
	public function			getRequest()
	{
		return $this->rootPresenter->getRequest();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	public function			getResponse()
	{
		return $this->rootPresenter->getResponse();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\RootPresenter')
	*/
	public function			getRootPresenter()
	{
		return $this->rootPresenter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			getParentPresenter()
	{
		return $this->parentPresenter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	public function			getPageContext()
	{
		return $this->getRootPresenter()->getPageContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setParentWithLead($parentPresenter)
	{
		$this->parentPresenter = $parentPresenter;
		$parentPresenter->setLeadChild($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCallerContext($callerContext)
	{
		$this->callerContext = $callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLanguage()
	{
		return $this->rootPresenter->getLanguage();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTitle($title)
	{
		$this->parentPresenter->setTitle($title);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			output($text)
	{
		$this->rootPresenter->output($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputFormat($format /* ... */)
	{
		$args = func_get_args();
		call_user_func_array(array($this->rootPresenter, "outputFormat"), $args);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			localize($classname, $text)
	{
		return $this->rootPresenter->localize($classname, $text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			localizeArgs($classname, $text, $args)
	{
		return $this->rootPresenter->localizeArgs($classname, $text, $args);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMessage($msgType, $message)
	{
		$this->rootPresenter->addMessage($msgType, $message);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addMessageLocalized($msgType, $classname, $message)
	{
		$this->rootPresenter->addMessageLocalized($msgType, $classname, $message);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createNotFoundPresenter()
	{
		return $this->parentPresenter->createNotFoundPresenter();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDeniedPresenter()
	{
		return $this->parentPresenter->createDeniedPresenter();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createUnallowedMethodPresenter()
	{
		return $this->parentPresenter->createUnallowedMethodPresenter();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDefaultPresenter()
	{
		return $this->parentPresenter->createDefaultPresenter();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	protected			$parentPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\RootPresenter')
	*/
	protected			$rootPresenter;
};


?>
