<?php

namespace net\dryuf\tenv\TestChild;


/**
@\net\dryuf\meta\FieldOrder(fields = { "testId", "childId" })
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
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
	public function			setTestId($testId_)
	{
		$this->testId = $testId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getTestId()
	{
		return $this->testId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setChildId($childId_)
	{
		$this->childId = $childId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			getChildId()
	{
		return $this->childId;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "testId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "guest")
	*/
	protected			$testId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	@\javax\persistence\Column(name = "childId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "_denied_", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$childId;

	/**
	*/
	function			__construct($testId = null, $childId = null)
	{
		parent::__construct();
		$this->testId = $testId;
		$this->childId = $childId;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->testId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->testId)))*37+(is_null($this->childId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->childId));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\tenv\TestChild\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->testId) ? is_null($s->testId) : ($this->testId === $s->testId)) && (is_null($this->childId) ? is_null($s->childId) : ($this->childId === $s->childId));
	}
};


?>
