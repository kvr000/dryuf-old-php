<?php

namespace net\dryuf\comp\gallery;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\gallery\GallerySection\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\gallery\GalleryHeader', composPkClazz = 'integer', composPath = "pk.galleryId", additionalPkFields = { "sectionCounter" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "displayName", "title", "description", "lastAdded", "recordCount" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "GallerySection")
*/
class GallerySection extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\gallery\GallerySection\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "displayName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$displayName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "title")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$title;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "description")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(60,8)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$description;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "lastAdded")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$lastAdded = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "recordCount")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$recordCount = 0;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setGalleryId($galleryId_)
	{
		$this->pk->setGalleryId($galleryId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getGalleryId()
	{
		return $this->pk->getGalleryId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSectionCounter($sectionCounter_)
	{
		$this->pk->setSectionCounter($sectionCounter_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getSectionCounter()
	{
		return $this->pk->getSectionCounter();
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
	public function			setTitle($title_)
	{
		$this->title = $title_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getTitle()
	{
		return $this->title;
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

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection\Pk')
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
