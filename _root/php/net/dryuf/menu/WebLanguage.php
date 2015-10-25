<?php

namespace net\dryuf\menu;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\menu\WebLanguage\Pk', pkField = "pk", composClazz = 'net\dryuf\menu\WebProvider', composPkClazz = 'string', composPath = "pk.providerName", additionalPkFields = { "language" })
@\net\dryuf\meta\FieldOrder(fields = { "pk" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WebLanguage")
*/
class WebLanguage extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\menu\WebLanguage\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

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
	public function			setLanguage($language_)
	{
		$this->pk->setLanguage($language_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLanguage()
	{
		return $this->pk->getLanguage();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage\Pk')
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
