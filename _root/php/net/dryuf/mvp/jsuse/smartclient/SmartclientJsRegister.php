<?php

namespace net\dryuf\mvp\jsuse\smartclient;


class SmartclientJsRegister extends \net\dryuf\mvp\NoLeadChildPresenter
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
		$rootPresenter->addLinkedContent("js", "isomorphicDir", "var isomorphicDir=\"".$rootPresenter->getContextPath()."isomorphic/\";");
		$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/isomorphic/system/modules/ISC_Core.js"));
		foreach ($this->options->getOptionDefault("jsFiles", \net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY) as $name) {
			$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/isomorphic/system/modules/".$name));
		}
		$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/isomorphic/skins/standard/load_skin.js"));
		parent::prepare();
	}
};


?>
