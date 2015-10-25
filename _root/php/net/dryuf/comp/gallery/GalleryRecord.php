<?php

namespace net\dryuf\comp\gallery;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\gallery\GalleryRecord\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\gallery\GallerySection', composPkClazz = 'net\dryuf\comp\gallery\GallerySection\Pk', composPath = "pk.gallerySection", additionalPkFields = { "recordCounter" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "created", "recordType", "displayName", "title", "description", "location" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "GalleryRecord")
*/
class GalleryRecord extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\gallery\GalleryRecord\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord\Pk')
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
	@\net\dryuf\core\Type(type = 'int')
	@\javax\persistence\Column(name = "recordType")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(120px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$recordType = 0;

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
	@\javax\persistence\Column(name = "title")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$title;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "description")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(60,8)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$description;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "location")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$location = "";

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setGallerySection($gallerySection_)
	{
		$this->pk->setGallerySection($gallerySection_);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection\Pk')
	*/
	public function			getGallerySection()
	{
		return $this->pk->getGallerySection();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRecordCounter($recordCounter_)
	{
		$this->pk->setRecordCounter($recordCounter_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRecordCounter()
	{
		return $this->pk->getRecordCounter();
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
	public function			setRecordType($recordType_)
	{
		$this->recordType = $recordType_;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getRecordType()
	{
		return $this->recordType;
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
	public function			setLocation($location_)
	{
		$this->location = $location_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLocation()
	{
		return $this->location;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord\Pk')
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
