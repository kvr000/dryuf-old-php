<?php

namespace net\dryuf\comp\forum;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "forumId", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "forumId", "refBase", "refKey", "label", "lastAdded", "recordCount" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "Forum.set", roleDel = "extreme")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "ForumHeader")
*/
class ForumHeader extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "forumId")
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "_denied_", roleDel = "extreme")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$forumId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refBase")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "Forum.set", roleDel = "extreme")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refBase;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refKey")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "Forum.set", roleDel = "extreme")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refKey;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "label")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "Forum.set", roleDel = "extreme")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$label;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "lastAdded")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "Forum.set", roleDel = "extreme")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$lastAdded = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "recordCount")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "guest", roleSet = "extreme", roleDel = "extreme")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$recordCount = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->forumId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($forumId_)
	{
		$this->forumId = $forumId_;
	}

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
	public function			setLabel($label_)
	{
		$this->label = $label_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLabel()
	{
		return $this->label;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLastAdded($lastAdded_)
	{
		$this->lastAdded = $lastAdded_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getLastAdded()
	{
		return $this->lastAdded;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRecordCount($recordCount_)
	{
		$this->recordCount = $recordCount_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRecordCount()
	{
		return $this->recordCount;
	}
};


?>
