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
		$this->options = array();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public static function		buildListed()
	{
		$this_ = new self();
		$args = func_get_args();
		for ($i = 0; $i < count($args); $i += 2) {
			$this_->options[$args[$i]] = $args[$i+1];
		}
		return $this_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getOptionMandatory($name)
	{
		if (!isset($this->options[$name]))
			throw new \net\dryuf\core\Exception("option $name not found");
		return $this->options[$name];
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getOptionDefault($name, $defaultValue)
	{
		return isset($this->options[$name]) ? $this->options[$name] : $defaultValue;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	function			cloneAddingListed()
	{
		$args = func_get_args();
		$this_ = new self();
		$this_->options = $this->options;
		for ($i = 0; $i < count($args); $i += 2) {
			$this_->options[$args[$i]] = $args[$i+1];
		}
		return $this_;
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
		$h = 0;
		foreach ($this->options as $k => $v) {
			$h += \net\dryuf\core\Dryuf::hashCodeObject($k)*31;
			$h += \net\dryuf\core\Dryuf::hashCodeObject($v)*31;
		}
		return $h;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\core\Options))
			return false;
		return $o->options == $this->options;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\HashMap<java\lang\String, java\lang\Object>')
	*/
	protected			$options;
};

Options::$NONE = Options::buildListed();


?>
