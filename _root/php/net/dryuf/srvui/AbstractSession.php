<?php

namespace net\dryuf\srvui;


abstract class AbstractSession extends \net\dryuf\core\Object implements \net\dryuf\srvui\Session
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getAttributeDefault($name, $defaultValue)
	{
		if (is_null(($value = $this->getAttribute($name))))
			$value = $defaultValue;
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getAttributeTextual($name, $textual)
	{
		if (is_null(($value = $this->getAttribute($name))))
			return null;
		return $textual->convert($value, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId)
	{
		$this->userId = $userId;
		$this->setAttribute('net\dryuf\srvui\Session'."._userId", $userId);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getUserId()
	{
		if (is_null($this->userId))
			$this->userId = $this->getAttribute('net\dryuf\srvui\Session'."._userId");
		return $this->userId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUsername($userName)
	{
		$this->userName = $userName;
		$this->setAttribute('net\dryuf\srvui\Session'."._userName", $userName);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getUsername()
	{
		if (is_null($this->userName))
			$this->userName = $this->getAttribute('net\dryuf\srvui\Session'."._userName");
		return $this->userName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$userId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$userName;
};


?>
