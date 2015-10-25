<?php

namespace net\dryuf\comp\forum\mvp;


class GuestbookPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$refBase = $options->getOptionDefault("refBase", \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\forum\mvp\GuestbookFormPresenter'));
		$refKey = $options->getOptionMandatory("refKey");
		$this->forumBo = $this->getCallerContext()->getBeanTyped("forumBo", 'net\dryuf\comp\forum\bo\ForumBo');
		$this->forumHandler = $this->forumBo->openCreateForumRef($this->getCallerContext(), $refBase, $refKey, "");
		$this->cssClass = \net\dryuf\core\Dryuf::dashClassname($options->getOptionDefault("cssClass", \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\forum\mvp\GuestbookPresenter')));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			init()
	{
		parent::init();
		if (is_null($this->markdownService))
			$this->markdownService = $this->getCallerContext()->getBeanTyped("markdownService", 'net\dryuf\text\markdown\MarkdownService');
		$this->form = \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\comp\forum\mvp\GuestbookFormPresenter', $this, \net\dryuf\core\Options::$NONE);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$response = $this->getRootPresenter()->getResponse();
		$response->setDateHeader("Expires", intval(microtime(true)*1000));
		$response->setHeader("Pragma", "no-cache");
		$response->setHeader("Cache-Control", "no-cache, must revalidate");
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		parent::render();
		$this->outputFormat("<div class='%s'>\n", $this->cssClass);
		$comments = new \net\dryuf\util\LinkedList();
		$this->forumHandler->listComments($comments, 0, null);
		foreach ($comments as $recordHolder) {
			$record = $recordHolder->getEntity();
			$this->outputFormat("<hr class='separator' />\n<div class=\"header\">");
			if (!(($record->getEmail()) == null))
				$this->outputFormat("<a class='email' href=\"mailto:%S\"><span class='name'>%S</span></a>", $record->getEmail(), $record->getName());
			else
				$this->outputFormat("<span class='name'>%S</span>", \net\dryuf\core\Dryuf::defvalue($record->getName(), ""));
			if (!(($record->getWebpage()) == null))
				$this->outputFormat(" (<a class='webpage' href=\"http://%S\">%S</a>)", $record->getWebpage(), $record->getWebpage());
			$this->outputFormat(" - <span class='added'>%S</span></div>\n", \net\dryuf\time\util\DateTimeUtil::formatLocalReadable(intval($record->getCreated())));
			$this->outputFormat("<div class='content'>%s</div>\n", $this->markdownService->convertToXhtml($record->getContent()));
		}
		$this->output("</div>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	protected			$forumHandler;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	public function			getForumHandler()
	{
		return $this->forumHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\text\markdown\MarkdownService')
	*/
	protected			$markdownService;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setMarkdownService($markdownService_)
	{
		$this->markdownService = $markdownService_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\bo\ForumBo')
	*/
	protected			$forumBo;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$cssClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\mvp\GuestbookFormPresenter')
	*/
	protected			$form;
};


?>
