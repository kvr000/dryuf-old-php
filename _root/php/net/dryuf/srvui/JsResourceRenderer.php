<?php

namespace net\dryuf\srvui;


class JsResourceRenderer extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->cssUrls = array();
		$this->jsUrls = array();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare($pageContext)
	{
		foreach ($this->cssUrls as $cssUrl) {
			$pageContext->addLinkedFile("css", \net\dryuf\srvui\PageUrl::createResource($cssUrl));
		}
		foreach ($this->jsUrls as $jsUrl) {
			$pageContext->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createResource($jsUrl));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render($pageContext)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$cssUrls;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getCssUrls()
	{
		return $this->cssUrls;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCssUrls($cssUrls_)
	{
		$this->cssUrls = $cssUrls_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$jsUrls;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getJsUrls()
	{
		return $this->jsUrls;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setJsUrls($jsUrls_)
	{
		$this->jsUrls = $jsUrls_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$jsImpl;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getJsImpl()
	{
		return $this->jsImpl;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setJsImpl($jsImpl_)
	{
		$this->jsImpl = $jsImpl_;
	}
};


?>
