<?php

namespace net\dryuf\comp\devel;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "created", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "created", "fileName", "fileSize", "fileContent" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\ListOrder(order = { "created DESC" })
@\net\dryuf\meta\FieldRoles(roleNew = "devel", roleGet = "devel", roleSet = "devel", roleDel = "devel")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "DevelFile")
*/
class DevelFile extends \net\dryuf\core\Object
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
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "created")
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "devel", roleGet = "devel", roleSet = "_denied_", roleDel = "devel")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$created;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "fileName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\FileTextual')
	@\net\dryuf\textual\DisplayUse(display = "file(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "devel", roleGet = "devel", roleSet = "devel", roleDel = "devel")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$fileName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "fileSize")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\LongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "devel", roleGet = "devel", roleSet = "devel", roleDel = "devel")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$fileSize;

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	@\javax\persistence\Column(name = "fileContent")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "hidden()")
	@\net\dryuf\meta\FieldRoles(roleNew = "devel", roleGet = "devel", roleSet = "devel", roleDel = "devel")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$fileContent;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->created;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($created_)
	{
		$this->created = $created_;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCreated($created_)
	{
		$this->created = $created_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCreated()
	{
		return $this->created;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setFileName($fileName_)
	{
		$this->fileName = $fileName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFileName()
	{
		return $this->fileName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setFileSize($fileSize_)
	{
		$this->fileSize = $fileSize_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getFileSize()
	{
		return $this->fileSize;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setFileContent($fileContent_)
	{
		$this->fileContent = $fileContent_;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			getFileContent()
	{
		return $this->fileContent;
	}
};


?>
