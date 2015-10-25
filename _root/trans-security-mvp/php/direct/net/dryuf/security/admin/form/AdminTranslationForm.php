<?php

namespace net\dryuf\security\admin\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "update", isStatic = false, formActioner = ".performUpdate", roleAction = "guest")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "translationLevel", "timing" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "AdminTranslationForm")
*/
class AdminTranslationForm extends \net\dryuf\core\Object
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
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	@\javax\persistence\Column(name = "translationLevel")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "select(120px, none^missing^all)")
	@\net\dryuf\meta\FieldRoles(roleNew = "translation", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$translationLevel = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	@\javax\persistence\Column(name = "timing")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\BoolSwitchTextual')
	@\net\dryuf\textual\DisplayUse(display = "checkbox()")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$timing = false;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTranslationLevel($translationLevel_)
	{
		$this->translationLevel = $translationLevel_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			getTranslationLevel()
	{
		return $this->translationLevel;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTiming($timing_)
	{
		$this->timing = $timing_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			getTiming()
	{
		return $this->timing;
	}
};


?>
