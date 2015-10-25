<?php

namespace net\dryuf\comp\poll;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\RelationDefs(relations = {
	@\net\dryuf\meta\RelationDef(name = "polls", targetClass = "net.dryuf.comp.poll.PollHeader")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "groupId", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "groupId", "refBase", "refKey" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "guest", roleSet = "Poll.update", roleDel = "Poll.update")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "PollGroup")
*/
class PollGroup extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "groupId")
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "guest", roleSet = "_denied_", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$groupId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refBase")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "guest", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refBase;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refKey")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "guest", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refKey;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->groupId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($groupId_)
	{
		$this->groupId = $groupId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setGroupId($groupId_)
	{
		$this->groupId = $groupId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getGroupId()
	{
		return $this->groupId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRefBase($refBase_)
	{
		$this->refBase = $refBase_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRefBase()
	{
		return $this->refBase;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRefKey($refKey_)
	{
		$this->refKey = $refKey_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRefKey()
	{
		return $this->refKey;
	}
};


?>
