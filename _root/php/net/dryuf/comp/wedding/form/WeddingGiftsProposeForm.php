<?php

namespace net\dryuf\comp\wedding\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "propose", isStatic = false, formActioner = ".performPropose", roleAction = "guest")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "yourEmail", "description" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WeddingGiftsProposeForm")
*/
class WeddingGiftsProposeForm extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "yourEmail")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$yourEmail;

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
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setYourEmail($yourEmail_)
	{
		$this->yourEmail = $yourEmail_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getYourEmail()
	{
		return $this->yourEmail;
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
};


?>
