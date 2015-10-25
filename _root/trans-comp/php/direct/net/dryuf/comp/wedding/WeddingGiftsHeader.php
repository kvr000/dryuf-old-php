<?php

namespace net\dryuf\comp\wedding;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "weddingGiftsId", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "weddingGiftsId", "refBase", "refKey", "contactEmail", "proposalEmail", "coordinatorEmail" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WeddingGiftsHeader")
*/
class WeddingGiftsHeader extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "weddingGiftsId")
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "_denied_", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$weddingGiftsId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refBase")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refBase;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refKey")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refKey;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "contactEmail")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$contactEmail;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "proposalEmail")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$proposalEmail;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "coordinatorEmail")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$coordinatorEmail;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->weddingGiftsId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($weddingGiftsId_)
	{
		$this->weddingGiftsId = $weddingGiftsId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setWeddingGiftsId($weddingGiftsId_)
	{
		$this->weddingGiftsId = $weddingGiftsId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getWeddingGiftsId()
	{
		return $this->weddingGiftsId;
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
	public function			setContactEmail($contactEmail_)
	{
		$this->contactEmail = $contactEmail_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContactEmail()
	{
		return $this->contactEmail;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setProposalEmail($proposalEmail_)
	{
		$this->proposalEmail = $proposalEmail_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProposalEmail()
	{
		return $this->proposalEmail;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCoordinatorEmail($coordinatorEmail_)
	{
		$this->coordinatorEmail = $coordinatorEmail_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCoordinatorEmail()
	{
		return $this->coordinatorEmail;
	}
};


?>
