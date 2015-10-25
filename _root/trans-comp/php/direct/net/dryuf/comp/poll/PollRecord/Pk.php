<?php

namespace net\dryuf\comp\poll\PollRecord;


/**
@\net\dryuf\meta\FieldOrder(fields = { "userId", "pollId" })
@\net\dryuf\meta\FieldRoles(roleNew = "Poll.vote", roleGet = "Poll.get", roleSet = "Poll.owner", roleDel = "Poll.owner")
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
	public function			setPollId($pollId_)
	{
		$this->pollId = $pollId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPollId()
	{
		return $this->pollId;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "userId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.vote", roleGet = "Poll.get", roleSet = "_denied_", roleDel = "Poll.owner")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$userId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "pollId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "Poll.get", roleSet = "_denied_", roleDel = "Poll.owner")
	*/
	protected			$pollId;

	/**
	*/
	function			__construct($userId = null, $pollId = null)
	{
		parent::__construct();
		$this->userId = $userId;
		$this->pollId = $pollId;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->userId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->userId)))*37+(is_null($this->pollId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->pollId));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\poll\PollRecord\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->userId) ? is_null($s->userId) : ($this->userId === $s->userId)) && (is_null($this->pollId) ? is_null($s->pollId) : ($this->pollId === $s->pollId));
	}
};


?>
