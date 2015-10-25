<?php

namespace net\dryuf\comp\forum\ForumRecord;


/**
@\net\dryuf\meta\FieldOrder(fields = { "forumId", "counter" })
@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "SqlForum.set", roleDel = "SqlForum.set")
@\javax\persistence\Embeddable
*/
class Pk extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setForumId($forumId_)
	{
		$this->forumId = $forumId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getForumId()
	{
		return $this->forumId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCounter($counter_)
	{
		$this->counter = $counter_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCounter()
	{
		return $this->counter;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "forumId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "extreme", roleSet = "_denied_", roleDel = "SqlForum.set")
	*/
	protected			$forumId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "counter")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "extreme", roleSet = "_denied_", roleDel = "SqlForum.set")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$counter;

	/**
	*/
	function			__construct($forumId = null, $counter = null)
	{
		parent::__construct();
		$this->forumId = $forumId;
		$this->counter = $counter;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->forumId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->forumId)))*37+(is_null($this->counter) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->counter));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\forum\ForumRecord\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->forumId) ? is_null($s->forumId) : ($this->forumId === $s->forumId)) && (is_null($this->counter) ? is_null($s->counter) : ($this->counter === $s->counter));
	}
};


?>
