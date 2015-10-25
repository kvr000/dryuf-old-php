<?php

namespace net\dryuf\comp\gallery\xml\XmlDomGalleryHandler;


class GallerySectionDom extends \net\dryuf\comp\gallery\GallerySection
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($sectionElement)
	{
		parent::__construct();
		$this->sectionElement = $sectionElement;
		$this->recordsElement = \net\dryuf\xml\util\DomUtil::getSingleElement($sectionElement, "records");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDisplayName()
	{
		if (is_null(($r = parent::getDisplayName()))) {
			$this->setDisplayName($r = \net\dryuf\xml\util\DomUtil::getAttributeMandatory($this->sectionElement, "id"));
		}
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getTitle()
	{
		return \net\dryuf\xml\util\DomUtil::getSubElementContentDefault($this->sectionElement, "title", $this->getDisplayName());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDescription()
	{
		return \net\dryuf\xml\util\DomUtil::getSubElementContentDefault($this->sectionElement, "description", "");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getLastAdded()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRecordCount()
	{
		return \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName(\net\dryuf\xml\util\DomUtil::getSingleElement($this->sectionElement, "records"), "record")->length;
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public				$sectionElement;

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public				$recordsElement;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	*/
	public				$records;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$location;
};


?>
