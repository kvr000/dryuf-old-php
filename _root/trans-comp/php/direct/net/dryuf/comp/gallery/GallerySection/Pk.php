<?php

namespace net\dryuf\comp\gallery\GallerySection;


/**
@\net\dryuf\meta\FieldOrder(fields = { "galleryId", "sectionCounter" })
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
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
	public function			setGalleryId($galleryId_)
	{
		$this->galleryId = $galleryId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getGalleryId()
	{
		return $this->galleryId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSectionCounter($sectionCounter_)
	{
		$this->sectionCounter = $sectionCounter_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getSectionCounter()
	{
		return $this->sectionCounter;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "galleryId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "guest")
	*/
	protected			$galleryId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "sectionCounter")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "_denied_", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$sectionCounter;

	/**
	*/
	function			__construct($galleryId = null, $sectionCounter = null)
	{
		parent::__construct();
		$this->galleryId = $galleryId;
		$this->sectionCounter = $sectionCounter;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->galleryId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->galleryId)))*37+(is_null($this->sectionCounter) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->sectionCounter));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\gallery\GallerySection\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->galleryId) ? is_null($s->galleryId) : ($this->galleryId === $s->galleryId)) && (is_null($this->sectionCounter) ? is_null($s->sectionCounter) : ($this->sectionCounter === $s->sectionCounter));
	}
};


?>
