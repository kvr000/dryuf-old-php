<?php

namespace net\dryuf\srvui;


class DummyUiContext extends \net\dryuf\core\AbstractUiContext
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
	public function			localize($class_name, $text)
	{
		return $text;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDefaultLanguage()
	{
		return $this->language;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLocalizePath()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			readLocalizedFile($filename)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

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
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkLanguage($language_)
	{
		if (($language_ === $this->language))
			return true;
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$language;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	public function			getClassLocalization($className)
	{
		return new \net\dryuf\util\php\StringNativeHashMap();
	}
};


?>
