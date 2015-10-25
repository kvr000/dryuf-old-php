<?php

namespace net\dryuf\menu;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'string', pkField = "providerName", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "providerName" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WebProvider")
*/
class WebProvider extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "providerName")
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "guest", roleSet = "sysconf", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$providerName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPk()
	{
		return $this->providerName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($providerName_)
	{
		$this->providerName = $providerName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setProviderName($providerName_)
	{
		$this->providerName = $providerName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProviderName()
	{
		return $this->providerName;
	}
};


?>
