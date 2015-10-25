<?php

namespace net\dryuf\comp\poll;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "Poll.create"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, roleAction = "Poll.update"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, roleAction = "Poll.update")
})
@\net\dryuf\meta\RelationDefs(relations = {
	@\net\dryuf\meta\RelationDef(name = "options", targetClass = "net.dryuf.comp.poll.PollOption")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "pollId", composClazz = 'net\dryuf\comp\poll\PollGroup', composPkClazz = 'integer', composPath = "groupId", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "groupId", "pollId", "created", "refBase", "refKey", "closed", "description", "totalVotes" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\ListOrder(order = { "pollId DESC" })
@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "PollHeader")
*/
class PollHeader extends \net\dryuf\core\Object
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
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "groupId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "Poll.get", roleSet = "_denied_", roleDel = "Poll.update")
	*/
	protected			$groupId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "pollId")
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "Poll.get", roleSet = "extreme", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$pollId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "created")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$created;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refBase")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refBase;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refKey")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refKey;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	@\javax\persistence\Column(name = "closed")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\BoolSwitchTextual')
	@\net\dryuf\textual\DisplayUse(display = "checkbox()")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$closed = false;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "description")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(80,20)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.create", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$description;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "totalVotes")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "Poll.get", roleSet = "extreme", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$totalVotes = 0;

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
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->pollId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($pollId_)
	{
		$this->pollId = $pollId_;
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

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setClosed($closed_)
	{
		$this->closed = $closed_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			getClosed()
	{
		return $this->closed;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDescription($description_)
	{
		$this->description = $description_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDescription()
	{
		return $this->description;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTotalVotes($totalVotes_)
	{
		$this->totalVotes = $totalVotes_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getTotalVotes()
	{
		return $this->totalVotes;
	}
};


?>
