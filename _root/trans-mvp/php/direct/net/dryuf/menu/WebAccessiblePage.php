<?php

namespace net\dryuf\menu;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\menu\WebAccessiblePage\Pk', pkField = "pk", composClazz = 'net\dryuf\menu\WebProvider', composPkClazz = 'string', composPath = "pk.providerName", additionalPkFields = { "pageCode" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "needSlash", "reqRole", "presenterImpl", "isSystem" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WebAccessiblePage")
*/
class WebAccessiblePage extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\menu\WebAccessiblePage\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebAccessiblePage\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	@\javax\persistence\Column(name = "needSlash")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\BoolSwitchTextual')
	@\net\dryuf\textual\DisplayUse(display = "checkbox()")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$needSlash = true;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "reqRole")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$reqRole;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "presenterImpl")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$presenterImpl;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	@\javax\persistence\Column(name = "isSystem")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\BoolSwitchTextual')
	@\net\dryuf\textual\DisplayUse(display = "checkbox()")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$isSystem = true;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setProviderName($providerName_)
	{
		$this->pk->setProviderName($providerName_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProviderName()
	{
		return $this->pk->getProviderName();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPageCode($pageCode_)
	{
		$this->pk->setPageCode($pageCode_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPageCode()
	{
		return $this->pk->getPageCode();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setNeedSlash($needSlash_)
	{
		$this->needSlash = $needSlash_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			getNeedSlash()
	{
		return $this->needSlash;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setReqRole($reqRole_)
	{
		$this->reqRole = $reqRole_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getReqRole()
	{
		return $this->reqRole;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPresenterImpl($presenterImpl_)
	{
		$this->presenterImpl = $presenterImpl_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPresenterImpl()
	{
		return $this->presenterImpl;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setIsSystem($isSystem_)
	{
		$this->isSystem = $isSystem_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			getIsSystem()
	{
		return $this->isSystem;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebAccessiblePage\Pk')
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
