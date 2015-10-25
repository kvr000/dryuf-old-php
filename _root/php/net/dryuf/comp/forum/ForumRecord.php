<?php

namespace net\dryuf\comp\forum;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\forum\ForumRecord\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\forum\ForumHeader', composPkClazz = 'integer', composPath = "pk.forumId", additionalPkFields = { "counter" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "created", "userId", "name", "email", "webpage", "content", "lastEdit" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\ListOrder(order = { "pk.forumId DESC", "pk.counter DESC" })
@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "ForumRecord")
*/
class ForumRecord extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\forum\ForumRecord\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumRecord\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "created")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$created;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "userId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$userId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "name")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(80,20)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$name;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "email")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$email;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "webpage")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\WebpageTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$webpage;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "content")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(60,8)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$content;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "lastEdit")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$lastEdit = 0;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setForumId($forumId_)
	{
		$this->pk->setForumId($forumId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getForumId()
	{
		return $this->pk->getForumId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCounter($counter_)
	{
		$this->pk->setCounter($counter_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCounter()
	{
		return $this->pk->getCounter();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCreated($created_)
	{
		$this->created = $created_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCreated()
	{
		return $this->created;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId_)
	{
		$this->userId = $userId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getUserId()
	{
		return $this->userId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setName($name_)
	{
		$this->name = $name_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getName()
	{
		return $this->name;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEmail($email_)
	{
		$this->email = $email_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getEmail()
	{
		return $this->email;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setWebpage($webpage_)
	{
		$this->webpage = $webpage_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getWebpage()
	{
		return $this->webpage;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setContent($content_)
	{
		$this->content = $content_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContent()
	{
		return $this->content;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLastEdit($lastEdit_)
	{
		$this->lastEdit = $lastEdit_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getLastEdit()
	{
		return $this->lastEdit;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumRecord\Pk')
	*/
	public function			getPk()
	{
		return $this->pk;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($pk_)
	{
		$this->pk = $pk_;
	}
};


?>
