<?php

namespace net\dryuf\comp\wedding\WeddingGiftsGift;


/**
@\net\dryuf\meta\FieldOrder(fields = { "weddingGiftsId", "displayName" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
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
	public function			setDisplayName($displayName_)
	{
		$this->displayName = $displayName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDisplayName()
	{
		return $this->displayName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "weddingGiftsId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "admin")
	*/
	protected			$weddingGiftsId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "displayName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "_denied_", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$displayName;

	/**
	*/
	function			__construct($weddingGiftsId = null, $displayName = null)
	{
		parent::__construct();
		$this->weddingGiftsId = $weddingGiftsId;
		$this->displayName = $displayName;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->weddingGiftsId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->weddingGiftsId)))*37+(is_null($this->displayName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->displayName));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\wedding\WeddingGiftsGift\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->weddingGiftsId) ? is_null($s->weddingGiftsId) : ($this->weddingGiftsId === $s->weddingGiftsId)) && (is_null($this->displayName) ? is_null($s->displayName) : ($this->displayName === $s->displayName));
	}
};


?>
