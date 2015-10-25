<?php

namespace net\dryuf\mvp;


class MainXhtmlPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		$this->statPresenters = new \net\dryuf\util\LinkedList();

		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createNotFoundPresenter()
	{
		return new \net\dryuf\mvp\NotFoundPresenter($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDeniedPresenter()
	{
		return new \net\dryuf\mvp\DeniedPresenter($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createUnallowedMethodPresenter()
	{
		return new \net\dryuf\mvp\UnallowedMethodPresenter($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			headDocumentUtf8()
	{
		$this->getRootPresenter()->getResponse()->setContentType("application/xhtml+xml; charset=UTF-8");
		$this->getRootPresenter()->addMetaHttp("Content-Type", "application/xhtml+xml; charset=UTF-8");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTitle($title)
	{
		if (is_null($this->baseTitle)) {
			$this->baseTitle = !(($title) == null) ? $title." - ".$this->getSiteTitle() : $this->getSiteTitle();
			$title = $this->baseTitle;
		}
		elseif (!(($title) == null)) {
			$title = $title." - ".$this->baseTitle;
		}
		parent::setTitle($title);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSiteTitle()
	{
		return "";
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->headDocumentUtf8();
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepareJsPackage($packageName)
	{
		$resourceResolver = $this->getCallerContext()->getBeanTyped("resourceResolver", 'net\dryuf\io\ResourceResolver');
		try {
			foreach (\net\dryuf\core\StringUtil::splitRegExp(stream_get_contents($resourceResolver->getMandatoryResourceAsStream("resources/".\net\dryuf\core\StringUtil::replaceRegExp($packageName, "\\.", "/")."/_jspkg.files"), "UTF-8"), "\n") as $file) {
				if ($file === "")
					continue;
				$this->getRootPresenter()->addLinkedFile("js", \net\dryuf\srvui\PageUrl::createRooted("/resources/".$file));
			}
		}
		catch (\net\dryuf\io\IoException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->renderDocumentStart();
		$this->renderHead();
		$this->renderBody();
		$this->renderDocumentEnd();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderDocumentStart()
	{
		$this->output("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderDocumentEnd()
	{
		$this->output("</html>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderHead()
	{
		$this->output("<head>\n");
		$this->renderMeta();
		$this->renderFavicon();
		$this->renderLinked();
		$this->renderTitle();
		$this->output("</head>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderMeta()
	{
		foreach ($this->getRootPresenter()->getMetas()->values() as $typedMetas) {
			foreach ($typedMetas->values() as $meta) {
				$this->outputFormat("<meta %s=%A content=%A />\n", $meta->getType(), $meta->getName(), $meta->getContent());
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderTitle()
	{
		$this->outputFormat("<title>%S</title>\n", $this->getRootPresenter()->getTitle());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderFavicon()
	{
		$this->outputFormat("<link rel=\"SHORTCUT ICON\" href=\"%U\" />\n", \net\dryuf\srvui\PageUrl::createRooted("/favicon.ico"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderLinked()
	{
		$this->renderLinkedCss();
		$this->renderLinkedJs();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderLinkedCss()
	{
		if (!is_null(($linked = $this->getRootPresenter()->getLinkedFiles("css")))) {
			$done = new \net\dryuf\util\HashSet();
			foreach ($linked as $file) {
				if ($done->contains($file))
					continue;
				$this->outputFormat("<link rel=\"STYLESHEET\" href=\"%U\" type=\"text/css\" />\n", $file);
				$done->add($file);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderLinkedJs()
	{
		if (!is_null(($linked = $this->getRootPresenter()->getLinkedFiles("js")))) {
			$done = new \net\dryuf\util\HashSet();
			foreach ($linked as $file) {
				if (substr($file->getUrl(), 0, strlen("@")) == "@") {
					if (strlen($file->getUrl()) > 1 && $done->contains($file))
						continue;
					$this->outputFormat("<script type=\"text/javascript\">\n%s\n</script>\n", $file->getOptions()->getOptionMandatory("content"));
				}
				else {
					if ($done->contains($file))
						continue;
					$this->outputFormat("<script type=\"text/javascript\" src=\"%U\"></script>\n", $file);
					$done->add($file);
				}
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderBodyAttributes()
	{
		if (!is_null($this->getRootPresenter()->getActiveField())) {
			$this->outputFormat(" onload=%A", "javascript:document.getElementById('".$this->getRootPresenter()->getActiveField()."').focus()");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderBody()
	{
		$this->output("<body");
		$this->renderBodyAttributes();
		$this->output(">\n");
		$this->renderBodyInner();
		$this->output("</body>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderBodyInner()
	{
		$this->output("<table width=\"100%\" cellspacing='0' cellpadding='0'><tr><td height='6' colspan='3'></td></tr><tr>\n\t<td width='140' valign='top'>\n");
		$this->renderMenu();
		$this->output("\t</td>\n\t<td width='6'></td>\n\t<td class='page-inner' valign='top'>\n");
		$this->renderMessages();
		$this->renderContent();
		$this->output("\t</td></tr>\n</table>\n");
		$this->renderStats();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderContent()
	{
		parent::render();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderMenu()
	{
		(new \net\dryuf\mvp\menu\VerticalMenuRenderer())->render($this, null, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderMessages()
	{
		$pendingMessages = $this->getRootPresenter()->getPendingMessages();
		if (!$pendingMessages->isEmpty()) {
			$this->output("<table class='page-messages'>\n");
			foreach ($pendingMessages as $msg) {
				$this->outputFormat("<tr><td><div class=%A>%S</div></td></tr>\n", "msg_type_".$msg->getType(), $msg->getMessage());
			}
			$this->output("</table>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addStat($presenter)
	{
		$this->statPresenters->add($presenter);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addW3CStat()
	{
		$this->addStat(new \net\dryuf\mvp\stat\W3cXhtmlPresenter($this, \net\dryuf\core\Options::$NONE));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addTimingStat()
	{
		if ($this->getUiContext()->getTiming()) {
			$this->addStat(new \net\dryuf\mvp\stat\TimingPresenter($this, \net\dryuf\core\Options::$NONE));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderStats()
	{
		if (!$this->statPresenters->isEmpty()) {
			$this->output("<table align='right'><tr>\n");
			foreach ($this->statPresenters as $presenter) {
				$this->output("<td>");
				$presenter->render();
				$this->output("</td>\n");
			}
			$this->output("</tr></table>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$baseTitle;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\mvp\Presenter>')
	*/
	protected			$statPresenters;
};


?>
