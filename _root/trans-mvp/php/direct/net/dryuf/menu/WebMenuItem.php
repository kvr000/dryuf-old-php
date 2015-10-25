<?php

namespace net\dryuf\menu;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'net\dryuf\menu\WebAccessiblePage', composPkClazz = 'net\dryuf\menu\WebAccessiblePage\Pk', composPath = "pageCode", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "pageCode", "parentItem", "subOrder" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "WebMenuItem")
*/
class WebMenuItem extends \net\dryuf\core\Object
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
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebAccessiblePage\Pk')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\EmbeddedId
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "admin")
	*/
	protected			$pageCode;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "parentItem")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$parentItem;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	@\javax\persistence\Column(name = "subOrder")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$subOrder;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPageCode($pageCode_)
	{
		$this->pageCode = $pageCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebAccessiblePage\Pk')
	*/
	public function			getPageCode()
	{
		return $this->pageCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setParentItem($parentItem_)
	{
		$this->parentItem = $parentItem_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getParentItem()
	{
		return $this->parentItem;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSubOrder($subOrder_)
	{
		$this->subOrder = $subOrder_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			getSubOrder()
	{
		return $this->subOrder;
	}
};


?>
