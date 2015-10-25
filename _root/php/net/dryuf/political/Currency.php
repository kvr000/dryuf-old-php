<?php

namespace net\dryuf\political;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "admin"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "admin")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'string', pkField = "currencyCode", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "currencyCode", "name" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Ref"),
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\SuggestDef(fields = { "currencyCode", "name" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "Currency")
*/
class Currency extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "currencyCode")
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "denied", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$currencyCode;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "name")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$name;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPk()
	{
		return $this->currencyCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($currencyCode_)
	{
		$this->currencyCode = $currencyCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCurrencyCode($currencyCode_)
	{
		$this->currencyCode = $currencyCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCurrencyCode()
	{
		return $this->currencyCode;
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
};


?>
