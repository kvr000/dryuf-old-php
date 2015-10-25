<?php

namespace net\dryuf\political;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "admin"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "admin"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, guiDef = "target=this", roleAction = "admin")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'string', pkField = "countryCode", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "countryCode", "name", "flag" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Ref"),
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\SuggestDef(fields = { "countryCode", "name" })
@\net\dryuf\meta\RefFieldsDef(fields = { "name" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "Country")
*/
class Country extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "countryCode")
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "_denied_", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$countryCode;

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
	@\javax\persistence\Column(name = "flag")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\FileTextual')
	@\net\dryuf\textual\DisplayUse(display = "file(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$flag;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPk()
	{
		return $this->countryCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($countryCode_)
	{
		$this->countryCode = $countryCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCountryCode($countryCode_)
	{
		$this->countryCode = $countryCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCountryCode()
	{
		return $this->countryCode;
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
	public function			setFlag($flag_)
	{
		$this->flag = $flag_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFlag()
	{
		return $this->flag;
	}
};


?>
