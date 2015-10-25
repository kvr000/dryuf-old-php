<?php

namespace net\dryuf\mvp;


class LoggerInterceptPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->subPresenter = $options->getOptionMandatory("subPresenter");
		$this->subOptions = $options->getOptionDefault("subOptions", \net\dryuf\core\Options::$NONE);
		$this->loggerIdentifier = $options->getOptionMandatory("loggerIdentifier");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$request = $this->getRequest();
		$logger = $this->getCallerContext()->getBeanTyped("loggerService", 'net\dryuf\service\logger\LoggerService')->getLogger($this->loggerIdentifier);
		$logger->logMessage($request->getMethod(), $request->getRemoteHost()." ".$request->getMethod()." \"".$this->getRootPresenter()->getFullUrl()."\" \"".\net\dryuf\core\Dryuf::defvalue($request->getHeader("User-Agent"), "")."\" \"".\net\dryuf\core\Dryuf::defvalue($request->getHeader("Referer"), "")."\"");
		\net\dryuf\mvp\Presenter::createSubPresenter($this->subPresenter, $this, $this->subOptions);
		return parent::process();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\mvp\Presenter>')
	*/
	public				$subPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public				$subOptions;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$loggerIdentifier;
};


?>
