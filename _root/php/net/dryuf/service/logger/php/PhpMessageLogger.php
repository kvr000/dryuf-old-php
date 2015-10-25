<?php

namespace net\dryuf\service\logger\php;


class PhpMessageLogger extends \net\dryuf\core\Object implements \net\dryuf\service\logger\MessageLogger
{
	public function			__construct($path)
	{
		$this->logFd = fopen($path, "a");
	}

	public function			__destruct()
	{
		fclose($this->logFd);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\logger\MessageLogger')
	 */
	public function                 logMessage($category, $message)
	{
		fputs($this->logFd, gmdate("c ").$message."\n");
	}

	protected			$logFd;
};


?>
