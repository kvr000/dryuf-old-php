<?php

namespace net\dryuf\service\logger\php;


class PhpLoggerService extends \net\dryuf\core\Object implements \net\dryuf\service\logger\LoggerService, \net\dryuf\core\AppContainerAware
{
	/**
	 */
	public function                 afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		if (is_null($this->logPath))
			$this->logPath = $appContainer->getWorkRoot()."log/";
		if (is_null($this->contextPath))
			$this->contextPath = $appContainer->getConfigValue('app.contextDomain');
		$this->basePath = $this->logPath.$this->contextPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\logger\MessageLogger')
	 */
	public function                 getLogger($identifier)
	{
		return new \net\dryuf\service\logger\php\PhpMessageLogger($this->basePath.$identifier.".log");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	@\javax\inject\Inject()
	 */
	protected			$appContainer;

	protected			$logPath;

	protected			$contextPath;
};


?>
