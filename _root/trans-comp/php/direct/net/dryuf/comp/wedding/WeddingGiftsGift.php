<?php

namespace net\dryuf\comp\wedding;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\wedding\WeddingGiftsGift\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\wedding\WeddingGiftsHeader', composPkClazz = 'integer', composPath = "pk.weddingGiftsId", additionalPkFields = { "displayName" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "inspirationUrl", "name", "description", "reservedCode" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WeddingGiftsGift")
*/
class WeddingGiftsGift extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\wedding\WeddingGiftsGift\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsGift\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "inspirationUrl")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\WebpageTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$inspirationUrl;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "name")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$name;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "description")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(60,8)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$description;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "reservedCode")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$reservedCode;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setWeddingGiftsId($weddingGiftsId_)
	{
		$this->pk->setWeddingGiftsId($weddingGiftsId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getWeddingGiftsId()
	{
		return $this->pk->getWeddingGiftsId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDisplayName($displayName_)
	{
		$this->pk->setDisplayName($displayName_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDisplayName()
	{
		return $this->pk->getDisplayName();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setInspirationUrl($inspirationUrl_)
	{
		$this->inspirationUrl = $inspirationUrl_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getInspirationUrl()
	{
		return $this->inspirationUrl;
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
	public function			setReservedCode($reservedCode_)
	{
		$this->reservedCode = $reservedCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getReservedCode()
	{
		return $this->reservedCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsGift\Pk')
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
