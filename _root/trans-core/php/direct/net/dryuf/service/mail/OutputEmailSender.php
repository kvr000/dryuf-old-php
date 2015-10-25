<?php

namespace net\dryuf\service\mail;


class OutputEmailSender extends \net\dryuf\core\Object implements \net\dryuf\service\mail\EmailSender
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
	public function			mailUtf8($to, $subject, $content, $from)
	{
		$this->loggerService->getLogger($this->loggerIdentifier)->logMessage("EMAIL", "sending e-mail to ".$to.", subject ".$subject.":\n".$content);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			mailAttachment($to, $subject, $content, $from, $attachment)
	{
		$this->loggerService->getLogger($this->loggerIdentifier)->logMessage("EMAIL", "sending e-mail to ".$to.", subject ".$subject.":\n".$content."\n\twith attachment ".$attachment->getName());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$loggerIdentifier = "email";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLoggerIdentifier()
	{
		return $this->loggerIdentifier;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLoggerIdentifier($loggerIdentifier_)
	{
		$this->loggerIdentifier = $loggerIdentifier_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\logger\LoggerService')
	@\javax\inject\Inject
	*/
	protected			$loggerService;
};


?>
