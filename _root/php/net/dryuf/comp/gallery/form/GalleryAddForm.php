<?php

namespace net\dryuf\comp\gallery\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "add", isStatic = false, formActioner = ".performAdd", roleAction = "regular")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "title", "description", "picture" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "GalleryAddForm")
*/
class GalleryAddForm extends \net\dryuf\core\Object
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
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$description;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "picture")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\FileTextual')
	@\net\dryuf\textual\DisplayUse(display = "file(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$picture;

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
	public function			setPicture($picture_)
	{
		$this->picture = $picture_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPicture()
	{
		return $this->picture;
	}
};


?>
