<?php

namespace net\dryuf\mvp\form;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "confirmCheck" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "ConfirmForm")
*/
class ConfirmForm extends \net\dryuf\core\Object
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
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	@\javax\persistence\Column(name = "confirmCheck")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\ConfirmSwitchTextual')
	@\net\dryuf\textual\DisplayUse(display = "checkbox()")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$confirmCheck = false;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setConfirmCheck($confirmCheck_)
	{
		$this->confirmCheck = $confirmCheck_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			getConfirmCheck()
	{
		return $this->confirmCheck;
	}
};


?>
