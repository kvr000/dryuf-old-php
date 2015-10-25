<?php

namespace net\dryuf\core;


/**
 * Container holding the dynamic construction options.
 */
class Options extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public static			$NONE;

	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->options = new \net\dryuf\util\php\StringNativeHashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public static function		buildListed($pairs)
	{
		$this_ = new \net\dryuf\core\Options();
		$this_->addListed($pairs);
		return $this_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getOptionMandatory($name)
	{
		if (!is_null(($value = $this->options->get($name))))
			return $value;
		throw new \net\dryuf\core\NullPointerException("option ".$name." is undefined");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getOptionDefault($name, $defaultValue)
	{
		$value = $this->options->get($name);
		if (!is_null($value))
			return $value;
		return $defaultValue;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public function			cloneAddingListed($pairs)
	{
		$copy = new \net\dryuf\core\Options();
		$copy->options = $this->options->clone();
		$copy->addListed($pairs);
		return $copy;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		addListed($pairs)
	{
		for ($i = 0; $i < count($pairs); ) {
			$name = $pairs[$i++];
			$value = $pairs[$i++];
			$this->options->put($name, $value);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return \net\dryuf\core\Dryuf::hashCodeObject($this->options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\core\Options))
			return false;
		$s = $o;
		return $s->options->size() == 0 && $this->options->size() == 0 || \net\dryuf\core\Dryuf::equalObjects($s->options, $this->options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\HashMap<java\lang\String, java\lang\Object>')
	*/
	protected			$options;

	public static function		_initManualStatic()
	{
		self::$NONE = new \net\dryuf\core\Options();
	}

};

\net\dryuf\core\Options::_initManualStatic();


?>
