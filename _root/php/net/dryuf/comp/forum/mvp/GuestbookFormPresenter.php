<?php

namespace net\dryuf\comp\forum\mvp;


class GuestbookFormPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->forumHandler = $parentPresenter->getForumHandler();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public static function		decodeIdentity($id)
	{
		if (!is_null(($regs = \net\dryuf\core\StringUtil::matchText("^([^|]*)\\|([^|]*)\\|([^|]*)\$", $id)))) {
			return array(
				$regs[1],
				$regs[2],
				$regs[3]
			);
		}
		else {
			return array( "", "", "" );
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		encodeIdentity($name, $email, $webpage)
	{
		if (is_null($name))
			$name = "";
		if (is_null($email))
			$email = "";
		if (is_null($webpage))
			$webpage = "";
		return $name."|".$email."|".$webpage;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\form\GuestbookForm')
	*/
	public function			createBackingObject()
	{
		return new \net\dryuf\comp\forum\form\GuestbookForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			initData()
	{
		parent::initData();
		$backing = $this->backingObject;
		$forvIds = $this->getRequest()->getCookie("guestbookIds");
		if (!is_null($forvIds)) {
			try {
				$decoded = \net\dryuf\comp\forum\mvp\GuestbookFormPresenter::decodeIdentity($forvIds);
				$backing->setName($decoded[0]);
				$backing->setEmail($decoded[1]);
				$backing->setWebpage($decoded[2]);
			}
			catch (\net\dryuf\core\Exception $ex) {
				$backing->setName("");
				$backing->setEmail("");
				$backing->setWebpage("");
			}
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performAdd($action)
	{
		$backing = $this->backingObject;
		$name = $backing->getName();
		$email = $backing->getEmail();
		$webpage = $backing->getWebpage();
		$content = \net\dryuf\core\StringUtil::replaceRegExp($backing->getContent(), "\r\n", "\n");
		$ids = \net\dryuf\comp\forum\mvp\GuestbookFormPresenter::encodeIdentity($name, $email, $webpage);
		$forumRecord = new \net\dryuf\comp\forum\ForumRecord();
		$forumRecord->setContent($content);
		$forumRecord->setEmail($email);
		$forumRecord->setWebpage($webpage);
		$forumRecord->setName($name);
		$this->forumHandler->addComment($forumRecord);
		$this->rootPresenter->getResponse()->setCookie("guestbookIds", $ids, 365*86400);
		$this->rootPresenter->getResponse()->redirect(".");
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	protected			$forumHandler;
};


?>
