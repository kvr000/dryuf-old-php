<?php

namespace net\dryuf\mvp;


abstract class TemplatingPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->replaceDirect = $options->getOptionDefault("replaceDirect", new \net\dryuf\util\HashMap());
		$this->replaceEscape = $options->getOptionDefault("replaceEscape", new \net\dryuf\util\HashMap());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$content = $this->readResource();
		foreach ($this->replaceDirect->entrySet() as $replaceEntry) {
			$content = \java\util\regex\Pattern::compile($replaceEntry->getKey(), \java\util\regex\Pattern::LITERAL)->matcher($content)->replaceAll($replaceEntry->getValue());
		}
		foreach ($this->replaceEscape->entrySet() as $replaceEntry) {
			$content = \java\util\regex\Pattern::compile($replaceEntry->getKey(), \java\util\regex\Pattern::LITERAL)->matcher($content)->replaceAll(htmlspecialchars($replaceEntry->getValue()));
		}
		$this->output($content);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	readResource();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$replaceDirect;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$replaceEscape;
};


?>
