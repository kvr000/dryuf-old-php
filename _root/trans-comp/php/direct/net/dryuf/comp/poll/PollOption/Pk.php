<?php

namespace net\dryuf\comp\poll\PollOption;


/**
@\net\dryuf\meta\FieldOrder(fields = { "pollId", "optionId" })
@\net\dryuf\meta\FieldRoles(roleNew = "Poll.update", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
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
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setOptionId($optionId_)
	{
		$this->optionId = $optionId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			getOptionId()
	{
		return $this->optionId;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "pollId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "Poll.get", roleSet = "extreme", roleDel = "Poll.update")
	*/
	protected			$pollId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	@\javax\persistence\Column(name = "optionId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.update", roleGet = "Poll.get", roleSet = "_denied_", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$optionId;

	/**
	*/
	function			__construct($pollId = null, $optionId = null)
	{
		parent::__construct();
		$this->pollId = $pollId;
		$this->optionId = $optionId;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->pollId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->pollId)))*37+(is_null($this->optionId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->optionId));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\poll\PollOption\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->pollId) ? is_null($s->pollId) : ($this->pollId === $s->pollId)) && (is_null($this->optionId) ? is_null($s->optionId) : ($this->optionId === $s->optionId));
	}
};


?>
