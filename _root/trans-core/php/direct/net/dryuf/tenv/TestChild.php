<?php

namespace net\dryuf\tenv;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\tenv\TestChild\Pk', pkField = "pk", composClazz = 'net\dryuf\tenv\TestMain', composPkClazz = 'integer', composPath = "pk.testId", additionalPkFields = { "childId" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "svalue" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "TestChild")
*/
class TestChild extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\tenv\TestChild\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\tenv\TestChild\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "svalue")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\ReferenceDef(loadAction = "loadSvalueRef", listAllAction = "listAllSvalueRefs", listNewAction = "listNewSvalueRefs", listSetAction = "listSetSvalueRefs")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$svalue;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTestId($testId_)
	{
		$this->pk->setTestId($testId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getTestId()
	{
		return $this->pk->getTestId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setChildId($childId_)
	{
		$this->pk->setChildId($childId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			getChildId()
	{
		return $this->pk->getChildId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSvalue($svalue_)
	{
		$this->svalue = $svalue_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSvalue()
	{
		return $this->svalue;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\tenv\TestChild\Pk')
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
