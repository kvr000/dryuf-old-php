<?php

namespace net\dryuf\mvp\menu;


class VerticalMenuRenderer extends \net\dryuf\mvp\AbstractStaticRenderer
{
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
		$presenter->outputFormat("<table class='lmenu' width='140' border='0' cellspacing='5' cellpadding='0'>\n");
		$this->renderMenuItems($presenter);
		$presenter->output("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderMenuItems($presenter)
	{
		$presenter->outputFormat("\t<tr><td><a href=\"%U\">%W</a>\n", \net\dryuf\srvui\PageUrl::createPaged(""), 'net\dryuf\mvp\MainXhtmlPresenter', "Main page");
		$presenter->output("\t<tr><td>");
		$this->renderLogged($presenter);
		$presenter->output("\t</td></tr>");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderLogged($presenter)
	{
		$presenter->outputFormat("<a href=\"%U\">%W</a>", \net\dryuf\srvui\PageUrl::createPaged(is_null($presenter->getCallerContext()->getUserId()) ? "login" : "logout"), 'net\dryuf\mvp\MainXhtmlPresenter', is_null($presenter->getCallerContext()->getUserId()) ? "Log in" : "Log out");
	}
};


?>
