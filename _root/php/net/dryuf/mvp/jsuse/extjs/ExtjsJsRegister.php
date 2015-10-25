<?php

namespace net\dryuf\mvp\jsuse\extjs;


class ExtjsJsRegister extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$rootPresenter = $this->getRootPresenter();
		$rootPresenter->addLinkedFile("css", \net\dryuf\srvui\PageUrl::createRooted("/extjs/resources/css/ext-all.css"));
		$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/extjs/ext-all-dev.js"));
		parent::prepare();
	}
};


?>
