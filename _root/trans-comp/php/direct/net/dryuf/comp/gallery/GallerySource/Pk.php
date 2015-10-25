<?php

namespace net\dryuf\comp\gallery\GallerySource;


/**
@\net\dryuf\meta\FieldOrder(fields = { "record", "sourceCounter" })
@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "Gallery.edit", roleDel = "Gallery.edit")
@\javax\persistence\Embeddable
*/
class Pk extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRecord($record_)
	{
		$this->record = $record_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord\Pk')
	*/
	public function			getRecord()
	{
		return $this->record;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSourceCounter($sourceCounter_)
	{
		$this->sourceCounter = $sourceCounter_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getSourceCounter()
	{
		return $this->sourceCounter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord\Pk')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "record")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "Gallery.read", roleSet = "_denied_", roleDel = "Gallery.edit")
	@\javax\persistence\Embedded
	*/
	protected			$record;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "sourceCounter")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "_denied_", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$sourceCounter;

	/**
	*/
	function			__construct($record = null, $sourceCounter = null)
	{
		parent::__construct();
		$this->record = $record;
		$this->sourceCounter = $sourceCounter;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->record) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->record)))*37+(is_null($this->sourceCounter) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->sourceCounter));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\gallery\GallerySource\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->record) ? is_null($s->record) : \net\dryuf\core\Dryuf::equalObjects($this->record, $s->record)) && (is_null($this->sourceCounter) ? is_null($s->sourceCounter) : ($this->sourceCounter === $s->sourceCounter));
	}
};


?>
