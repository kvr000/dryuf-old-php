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
		$this->dynamic = new \stdClass();
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
		$this->dynamic->$key = $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getDynamic($key)
	{
		return property_exists($this->dynamic, $key) ? $this->dynamic->$key : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getDynamicDefault($key, $defaultValue)
	{
		return property_exists($this->dynamic, $key) ? $this->dynamic->$key : $defaultValue;
	}

	/**
	@\net\dryuf\core\Type(type = 'stdClass')
	*/
	protected			$dynamic;
};


?>
