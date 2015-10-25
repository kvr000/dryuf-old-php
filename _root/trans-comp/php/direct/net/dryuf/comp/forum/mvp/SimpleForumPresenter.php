<?php

namespace net\dryuf\comp\forum\mvp;


class SimpleForumPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $forumHandler)
	{
		parent::__construct($parentPresenter, $options);
		$this->options = $options;
		$this->forumHandler = $forumHandler;
		$this->cssClass = \net\dryuf\core\Dryuf::dashClassname($options->getOptionDefault("cssClass", \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\forum\mvp\SimpleForumPresenter')));
		$this->cssFile = $options->getOptionDefault("cssFile", null);
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
		if (!is_null($this->cssFile))
			$this->getRootPresenter()->addLinkedFile("css", \net\dryuf\srvui\PageUrl::createResource($this->cssFile));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		if ($this->getCallerContext()->checkRole("Forum.add")) {
			new \net\dryuf\comp\forum\mvp\SimpleForumFormPresenter($this, \net\dryuf\core\Options::$NONE, $this->forumHandler);
		}
		else {
			new \net\dryuf\mvp\NeedLoginPresenter($this, \net\dryuf\core\Options::buildListed("messageClass", 'net\dryuf\comp\forum\mvp\SimpleForumPresenter', "message", "You need to --login-- to post messages."));
		}
		return parent::process();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<div class=\"%S\">\n", $this->cssClass);
		parent::render();
		if ($this->getCallerContext()->checkRole("Forum.get")) {
			$comments = new \net\dryuf\util\LinkedList();
			$this->forumHandler->listComments($comments, 0, null);
			$userAccountBo = $this->options->getOptionDefault("userAccountBo", null);
			if (is_null($userAccountBo))
				$userAccountBo = $this->getCallerContext()->getBean("userAccountBo");
			$userAccountTextual = $this->options->getOptionDefault("userAccountTextual", null);
			if (is_null($userAccountTextual))
				$userAccountTextual = \net\dryuf\textual\TextualManager::createTextual('net\dryuf\security\textual\UserAccountTextual', $this->getCallerContext());
			$datetimeTextual = $this->options->getOptionDefault("dateTimeTextual", null);
			if (is_null($datetimeTextual))
				$datetimeTextual = \net\dryuf\textual\TextualManager::createTextual('net\dryuf\textual\DateTimeTextual', $this->getCallerContext());
			if ($comments->size() == 0) {
				$this->outputFormat("<p class='noComments'>%W</p>\n", 'net\dryuf\comp\forum\mvp\SimpleForumPresenter', "No comments have been added yet.");
			}
			else {
				$even = true;
				$this->outputFormat("<table class='comments'>\n", \net\dryuf\core\Dryuf::dashClassname($this->cssClass));
				foreach ($comments as $recordHolder) {
					$record = $recordHolder->getEntity();
					$this->outputFormat("<tr class='header-%s'><td><span class='author'>%K</span>, <span class='addedTime'>%K</span></td></tr><tr class='row-%s'><td class='content'>%S</td></tr>\n", $even ? "even" : "odd", $userAccountTextual, $record->getUserId(), $datetimeTextual, $record->getCreated(), $even ? "even" : "odd", $record->getContent());
				}
				$this->outputFormat("</table>\n");
			}
		}
		else {
			(new \net\dryuf\mvp\NeedLoginPresenter($this, \net\dryuf\mvp\NoLeadChildPresenter::$NOLEAD_OPTIONS->cloneAddingListed("messageClass", 'net\dryuf\comp\forum\mvp\SimpleForumPresenter', "message", "You need to --login-- to see messages.")))->render();
		}
		$this->output("</div>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	protected			$forumHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$cssClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$cssFile;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	protected			$options;
};


?>
