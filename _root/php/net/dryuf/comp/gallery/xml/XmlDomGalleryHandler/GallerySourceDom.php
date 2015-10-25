<?php

namespace net\dryuf\comp\gallery\xml\XmlDomGalleryHandler;


class GallerySourceDom extends \net\dryuf\comp\gallery\GallerySource
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($record, $sourceElement)
	{
		parent::__construct();
		$this->sourceElement = $sourceElement;
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
			$this->setDisplayName($r = \net\dryuf\xml\util\DomUtil::getAttributeMandatory($this->sourceElement, "file"));
		}
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMimeType()
	{
		if (is_null(($r = parent::getMimeType()))) {
			$this->setMimeType($r = \net\dryuf\xml\util\DomUtil::getAttributeMandatory($this->sourceElement, "mimeType"));
		}
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public				$sourceElement;
};


?>
