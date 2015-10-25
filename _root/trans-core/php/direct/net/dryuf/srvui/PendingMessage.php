<?php

namespace net\dryuf\srvui;


class PendingMessage extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($type, $message)
	{
		parent::__construct();
		$this->type = $type;
		$this->message = $message;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getType()
	{
		return $this->type;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$type = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMessage()
	{
		return $this->message;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$message;
};


?>
