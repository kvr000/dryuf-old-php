<?php

namespace net\dryuf\core;


abstract class AbstractUiContext extends \net\dryuf\core\Object implements \net\dryuf\core\UiContext
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			localizeArgs($class_name, $text, $args)
	{
		return $this->localizeArgsEscape(
			function ($v) {
				return $v;
			}, 
			$class_name, 
			$text, 
			$args);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			localizeArgsEscape($escaper, $class_name, $text, $args)
	{
		$out = new \net\dryuf\core\StringBuilder();
		while (!is_null(($match = \net\dryuf\core\StringUtil::matchText("^(.*)\\{(\\d+)\\}(.*)\$", $text)))) {
			$out->append($match[1])->append(call_user_func($escaper, strval($args[\net\dryuf\core\Dryuf::parseInt($match[2])])));
			$text = $match[3];
		}
		$out->append($text);
		return strval($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			listLanguages()
	{
		return array();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLocalizeContextPath($path)
	{
		$this->localizeContextPath = $path;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$language;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLanguage()
	{
		return $this->language;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLanguage($language_)
	{
		$this->language = $language_;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$localizeDebug = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLocalizeDebug()
	{
		return $this->localizeDebug;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLocalizeDebug($localizeDebug_)
	{
		$this->localizeDebug = $localizeDebug_;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$timing = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			getTiming()
	{
		return $this->timing;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTiming($timing_)
	{
		$this->timing = $timing_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$localizeContextPath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLocalizeContextPath()
	{
		return $this->localizeContextPath;
	}
};


?>
