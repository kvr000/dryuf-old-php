<?php

namespace net\dryuf\comp\gallery\GalleryRecord;


/**
@\net\dryuf\meta\FieldOrder(fields = { "gallerySection", "recordCounter" })
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
	public function			setGallerySection($gallerySection_)
	{
		$this->gallerySection = $gallerySection_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection\Pk')
	*/
	public function			getGallerySection()
	{
		return $this->gallerySection;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRecordCounter($recordCounter_)
	{
		$this->recordCounter = $recordCounter_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRecordCounter()
	{
		return $this->recordCounter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection\Pk')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "gallerySection")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "Gallery.read", roleSet = "_denied_", roleDel = "Gallery.edit")
	@\javax\persistence\Embedded
	*/
	protected			$gallerySection;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "recordCounter")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Gallery.edit", roleGet = "Gallery.read", roleSet = "_denied_", roleDel = "Gallery.edit")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$recordCounter;

	/**
	*/
	function			__construct($gallerySection = null, $recordCounter = null)
	{
		parent::__construct();
		$this->gallerySection = $gallerySection;
		$this->recordCounter = $recordCounter;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->gallerySection) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->gallerySection)))*37+(is_null($this->recordCounter) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->recordCounter));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\gallery\GalleryRecord\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->gallerySection) ? is_null($s->gallerySection) : \net\dryuf\core\Dryuf::equalObjects($this->gallerySection, $s->gallerySection)) && (is_null($this->recordCounter) ? is_null($s->recordCounter) : ($this->recordCounter === $s->recordCounter));
	}
};


?>
