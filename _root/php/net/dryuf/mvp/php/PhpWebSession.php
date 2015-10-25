<?php

namespace net\dryuf\mvp\php;


class PhpWebSession extends \net\dryuf\srvui\AbstractSession
{
	/**
	*/
	public function			__construct()
	{
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	public function			invalidate()
	{
		session_destroy();
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	public function			getSessionId()
	{
		return session_id();
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	public function			removeAttribute($name)
	{
		unset($_SESSION[$name]);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	public function			setAttribute($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.Object")
	*/
	public function			getAttribute($name)
	{
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\util\Map<java\lang\String, java\lang\Object>')
	*/
	function			getAllAttributes()
	{
		$map = new \net\dryuf\util\LinkedHashMap();
		foreach ($_SESSION as $key => $value) {
			$map->put($key, $value);
		}
		return $map;
	}

};


?>
