<?php

namespace net\dryuf\comp\gallery\xml\XmlDomGalleryHandler;


class GalleryRecordDom extends \net\dryuf\comp\gallery\GalleryRecord
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($section, $recordElement)
	{
		parent::__construct();
		$this->section = $section;
		$this->recordElement = $recordElement;
		$this->sourcesElement = \net\dryuf\xml\util\DomUtil::getOptionalElement($recordElement, "sources");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCreated()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDisplayName()
	{
		if (is_null(($r = parent::getDisplayName()))) {
			$this->setDisplayName($r = \net\dryuf\xml\util\DomUtil::getAttributeMandatory($this->recordElement, "file"));
		}
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getRecordType()
	{
		if (($r = parent::getRecordType()) == \net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Unknown) {
			$recordTypeString = \net\dryuf\xml\util\DomUtil::getAttributeDefault($this->recordElement, "recordType", "picture");
			switch ($recordTypeString) {
			case "picture":
				$r = \net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture;
				break;

			case "video":
				$r = \net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Video;
				break;

			default:
				throw new \net\dryuf\core\RuntimeException("Unsupported recordType: ".$recordTypeString);
			}
			parent::setRecordType($r);
		}
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getTitle()
	{
		return \net\dryuf\xml\util\DomUtil::getSubElementContentDefault($this->recordElement, "title", $this->getDisplayName());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDescription()
	{
		if (is_null(($r = parent::getDescription()))) {
			if (is_null(($r = \net\dryuf\xml\util\DomUtil::getSubElementContentDefault($this->recordElement, "description", null))))
				$r = $this->getTitle();
			parent::setDescription($r);
		}
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom')
	*/
	public function			getSectionPrevious()
	{
		$previous = \net\dryuf\xml\util\DomUtil::getPreviousSameSibling($this->recordElement);
		if (is_null($previous))
			return null;
		return new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($this->section, $previous);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom')
	*/
	public function			getSectionNext()
	{
		$next = \net\dryuf\xml\util\DomUtil::getNextSameSibling($this->recordElement);
		if (is_null($next))
			return null;
		return new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($this->section, $next);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom')
	*/
	public function			getFullPrevious()
	{
		if (!is_null(($previousRecord = $this->getSectionPrevious())))
			return $previousRecord;
		if (is_null(($previousSectionElement = \net\dryuf\xml\util\DomUtil::getPreviousSameSibling($this->section->sectionElement))))
			return null;
		$previousSection = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom($previousSectionElement);
		if (is_null(($lastRecordElement = \net\dryuf\xml\util\DomUtil::getLastElementByName($previousSection->recordsElement, "record"))))
			return null;
		return new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($previousSection, $lastRecordElement);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom')
	*/
	public function			getFullNext()
	{
		if (!is_null(($nextRecord = $this->getSectionNext())))
			return $nextRecord;
		if (is_null(($nextSectionElement = \net\dryuf\xml\util\DomUtil::getNextSameSibling($this->section->sectionElement))))
			return null;
		$nextSection = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom($nextSectionElement);
		if (is_null(($firstRecordElement = \net\dryuf\xml\util\DomUtil::getFirstElementByName($nextSection->recordsElement, "record"))))
			return null;
		return new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($nextSection, $firstRecordElement);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom')
	*/
	public				$section;

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public				$recordElement;

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public				$sourcesElement;
};


?>
