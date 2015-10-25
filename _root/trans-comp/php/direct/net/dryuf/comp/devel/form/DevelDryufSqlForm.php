<?php

namespace net\dryuf\comp\devel\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "runSql", isStatic = false, formActioner = ".performRunSql", roleAction = "devel")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "sqlFile", "sql" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "DevelDryufSqlForm")
*/
class DevelDryufSqlForm extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "sqlFile")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\FileTextual')
	@\net\dryuf\textual\DisplayUse(display = "file(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$sqlFile;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "sql")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(60,8)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$sql;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSqlFile($sqlFile_)
	{
		$this->sqlFile = $sqlFile_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSqlFile()
	{
		return $this->sqlFile;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSql($sql_)
	{
		$this->sql = $sql_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSql()
	{
		return $this->sql;
	}
};


?>
