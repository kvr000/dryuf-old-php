<?php

namespace net\dryuf\comp\gallery;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\gallery\GallerySource\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\gallery\GalleryRecord', composPkClazz = 'net\dryuf\comp\gallery\GalleryRecord\Pk', composPath = "pk.record", additionalPkFields = { "sourceCounter" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "created", "displayName", "mimeType" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "GallerySource")
*/
class GallerySource extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\gallery\GallerySource\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySource\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "created")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$created;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "displayName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$displayName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "mimeType")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$mimeType;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRecord($record_)
	{
		$this->pk->setRecord($record_);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord\Pk')
	*/
	public function			getRecord()
	{
		return $this->pk->getRecord();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSourceCounter($sourceCounter_)
	{
		$this->pk->setSourceCounter($sourceCounter_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getSourceCounter()
	{
		return $this->pk->getSourceCounter();
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
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setMimeType($mimeType_)
	{
		$this->mimeType = $mimeType_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMimeType()
	{
		return $this->mimeType;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySource\Pk')
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
