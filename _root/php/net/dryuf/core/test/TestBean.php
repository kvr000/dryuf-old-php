<?php

namespace net\dryuf\core\test;


class TestBean extends \net\dryuf\core\Object implements \net\dryuf\core\AppContainerAware
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
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	public function			getAppContainer()
	{
		return $this->appContainer;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\logger\LoggerService')
	*/
	public function			getLoggerService()
	{
		return $this->loggerService;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\text\mime\MimeTypeService')
	*/
	public function			getMimeTypeService()
	{
		return $this->mimeTypeService;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			getTimeBo()
	{
		return $this->timeBo;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\image\CaptchaService')
	*/
	public function			getCaptchaService()
	{
		return $this->captchaService;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\inject\Inject
	*/
	public function			setMimeTypeService($mimeTypeService)
	{
		$this->mimeTypeService = $mimeTypeService;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTimeBo($timeBo)
	{
		$this->timeBo = true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCaptchaService($captchaService)
	{
		$this->captchaService = $captchaService;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	protected			$appContainer;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$timeBo = false;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\logger\LoggerService')
	@\javax\inject\Inject
	*/
	protected			$loggerService;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\text\mime\MimeTypeService')
	*/
	protected			$mimeTypeService;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\image\CaptchaService')
	*/
	protected			$captchaService;
};


?>
