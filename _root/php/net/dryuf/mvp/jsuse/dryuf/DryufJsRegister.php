<?php

namespace net\dryuf\mvp\jsuse\dryuf;


class DryufJsRegister extends \net\dryuf\mvp\NoLeadChildPresenter
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
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/dryuf.js"));
		$this->getRootPresenter()->addLinkedContent("js", "drufinit", "net.dryuf.serverPath=\"".$rootPresenter->getContextPath()."/\";");
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/core/ParallelSync.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/gui/GuiDom.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/xml/DomUtil.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/core/Base64.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/core/Eval.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/core/Ajax.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/core/RoleContext.js"));
		$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/net/dryuf/core/RoleContextHolder.js"));
		$sb = new \net\dryuf\core\StringBuilder();
		$sb->append("net.dryuf.core.RoleContextHolder.setSysRole(new net.dryuf.core.RoleContext(null, [ ");
		foreach ($this->getCallerContext()->getRoles() as $rname)
			$sb->append("\"")->append(htmlspecialchars($rname))->append("\", ");
		$sb->append("]));");
		$this->getRootPresenter()->addLinkedContent("js", "drufrole", strval($sb));
		foreach ($this->options->getOptionDefault("jsFiles", array()) as $name) {
			$rootPresenter->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/".$name));
		}
		if ($this->getCallerContext()->getConfigValue("net.dryuf.js.forceFull", false))
			$rootPresenter->getLeadChild()->prepareJsPackage("org.dryuf");
		parent::prepare();
	}
};


?>
