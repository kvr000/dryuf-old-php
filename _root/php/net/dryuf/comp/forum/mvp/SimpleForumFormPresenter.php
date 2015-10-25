<?php

namespace net\dryuf\comp\forum\mvp;


class SimpleForumFormPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $forumHandler)
	{
		parent::__construct($parentPresenter, $options);
		$this->forumHandler = $forumHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\form\SimpleForumForm')
	*/
	public function			createBackingObject()
	{
		return new \net\dryuf\comp\forum\form\SimpleForumForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performAdd($action)
	{
		$simpleForumForm = $this->getBackingObject();
		$forumRecord = new \net\dryuf\comp\forum\ForumRecord();
		$forumRecord->setContent($simpleForumForm->getContent());
		$forumRecord->setUserId($this->getCallerContext()->getUserId());
		$this->forumHandler->addComment($forumRecord);
		$this->getRootPresenter()->getResponse()->redirect(".");
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->output("<div class='add'>\n");
		parent::render();
		$this->output("</div>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	protected			$forumHandler;
};


?>
