<?php

namespace net\dryuf\comp\wedding\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "cancelReservation", isStatic = false, formActioner = ".performCancel", roleAction = "guest")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "reservedCode" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WeddingGiftsCancelForm")
*/
class WeddingGiftsCancelForm extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "reservedCode")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$reservedCode;

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
};


?>
