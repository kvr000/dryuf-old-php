<?php

namespace net\dryuf\mvp\menu;


class HorizontalItemMenuRenderer extends \net\dryuf\mvp\AbstractStaticRenderer
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\dao\WebMenuItemDao')
	@\javax\inject\Inject
	*/
	protected			$webMenuItemDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\dao\WebAccessiblePageDao')
	@\javax\inject\Inject
	*/
	protected			$webAccessiblePageDao;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$webProvider;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getWebProvider()
	{
		return $this->webProvider;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setWebProvider($webProvider_)
	{
		$this->webProvider = $webProvider_;
	}

	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render($presenter, $obj, $carrier)
	{
		$presenter->output("<div class=\"menu\"><ul>\n");
		foreach ($this->webMenuItemDao->listPagesRooted($this->webProvider) as $webPage) {
			if (!$presenter->getCallerContext()->checkRole($webPage->getReqRole()))
				continue;
			$presenter->outputFormat("\t<li>\n\t\t");
			if (($webPage->getPageCode() === "login")) {
				$this->renderLogged($presenter);
			}
			else {
				$presenter->outputFormat("<a class=\"hide\" href=\"%U\">%S</a>\n", \net\dryuf\srvui\PageUrl::createPaged($webPage->getPageCode()), $webPage->getPageCode());
			}
			$this->renderSubMenu($presenter, $webPage);
			$presenter->outputFormat("\t</li>\n");
		}
		$presenter->output("</ul></div>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderSubMenu($presenter, $webPage)
	{
		$presenter->output("\t\t<ul>\n");
		foreach ($this->webMenuItemDao->listPagesByParent($this->webProvider, $webPage->getPageCode()) as $subPage) {
			if (!$presenter->getCallerContext()->checkRole($subPage->getReqRole()))
				continue;
			$presenter->outputFormat("\t\t\t<li>\n\t\t\t\t<a class=\"hide\" href=\"%U\">%S</a>\n", \net\dryuf\srvui\PageUrl::createPaged($subPage->getPageCode()), $subPage->getPageCode());
			$presenter->outputFormat("\t\t\t</li>\n");
		}
		$presenter->output("\t\t</ul>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderMenuItems($presenter)
	{
		$presenter->outputFormat("\t\t\t<tr><td><a class='lmenu' href=\"%U\">%W</a>\n", \net\dryuf\srvui\PageUrl::createPaged(""), 'net\dryuf\mvp\MainXhtmlPresenter', "Main page");
		$presenter->output("\t\t\t<tr><td>");
		$this->renderLogged($presenter);
		$presenter->output("\t\t\t</td></tr>");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderLogged($presenter)
	{
		$presenter->outputFormat("<a class='lmenu' href=\"%U\">%W</a>\n", \net\dryuf\srvui\PageUrl::createPaged(is_null($presenter->getCallerContext()->getUserId()) ? "login" : "logout"), 'net\dryuf\mvp\MainXhtmlPresenter', is_null($presenter->getCallerContext()->getUserId()) ? "Log in" : "Log out");
	}
};


?>
