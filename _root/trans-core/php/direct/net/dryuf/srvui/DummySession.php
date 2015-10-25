<?php

namespace net\dryuf\srvui;


class DummySession extends \net\dryuf\srvui\AbstractSession
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->sessionAttributes = new \net\dryuf\util\php\StringNativeHashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			invalidate()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSessionId()
	{
		return "0123";
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			removeAttribute($name)
	{
		$this->sessionAttributes->remove($name);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAttribute($name, $value)
	{
		$this->sessionAttributes->put($name, $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getAttribute($name)
	{
		return $this->sessionAttributes->get($name);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getAllAttributes()
	{
		return $this->sessionAttributes;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\HashMap<java\lang\String, java\lang\Object>')
	*/
	protected			$sessionAttributes;
};


?>
