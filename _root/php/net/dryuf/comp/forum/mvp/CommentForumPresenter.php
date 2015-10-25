<?php

namespace net\dryuf\comp\forum\mvp;


class CommentForumPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $forumHandler)
	{
		parent::__construct($parentPresenter, $options);
		$this->forumHandler = $forumHandler;
		$this->getRootPresenter()->addLinkedFile("css", \net\dryuf\srvui\PageUrl::createRooted("/css/net/dryuf/comp/forum/CommentForum.css"));
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
		$comments = new \net\dryuf\util\LinkedList();
		$this->forumHandler->listComments($comments, 0, null);
		$this->output("<table class=\"net-dryuf-forum-CommentForum\">\n");
		$this->outputFormat("<tr><td colspan='2'>%W</td></tr>", 'net\dryuf\comp\forum\mvp\CommentForumPresenter', "Add new comment");
		foreach ($comments as $recordHolder) {
			$record = $recordHolder->getEntity();
			$this->output("<tr><td colspan='2'><hr/></td></tr>");
			$this->outputFormat("<tr class=\"comment\"><td colspan='2'>%S</td>\n", $record->getContent());
			$this->output("</tr>\n");
		}
		$this->output("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	protected			$forumHandler;
};


?>
