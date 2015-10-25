<?php

namespace net\dryuf\mvp\jsuse\yui;


class YuiJsRegister extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	protected			$options;

	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->options = $options;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$rootPresenter = $this->getRootPresenter();
		$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/yui/yui-base/yui-base-debug.js"));
		foreach ($this->options->getOptionDefault("jsFiles", \net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY) as $name) {
			$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/yui/".$name));
		}
		foreach ($this->options->getOptionDefault("cssFiles", \net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY) as $name) {
			$rootPresenter->addLinkedFile("css", \net\dryuf\srvui\PageUrl::createRooted("/yui/".$name));
		}
		parent::prepare();
	}
};


?>
