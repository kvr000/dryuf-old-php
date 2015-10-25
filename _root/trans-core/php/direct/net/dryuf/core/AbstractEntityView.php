<?php

namespace net\dryuf\core;


/**
 * Default implementation of {@link EntityView}.
 */
class AbstractEntityView extends \net\dryuf\core\Object implements \net\dryuf\core\EntityView
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addDynamic($key, $value)
	{
		if (is_null($this->dynamic))
			$this->dynamic = new \net\dryuf\util\php\StringNativeHashMap();
		$this->dynamic->put($key, $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getDynamic($key)
	{
		return is_null($this->dynamic) ? null : $this->dynamic->get($key);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getDynamicDefault($key, $defaultValue)
	{
		return !is_null($this->dynamic) && $this->dynamic->containsKey($key) ? $this->dynamic->get($key) : $defaultValue;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$dynamic;
};


?>
