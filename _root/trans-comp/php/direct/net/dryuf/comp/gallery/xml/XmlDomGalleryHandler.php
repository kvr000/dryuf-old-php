<?php

namespace net\dryuf\comp\gallery\xml;


class XmlDomGalleryHandler extends \net\dryuf\comp\gallery\ReadonlyGalleryHandler
{
	/**
	*/
	function			__construct($callerContext, $galleryDir)
	{
		parent::__construct($callerContext, $galleryDir);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			read()
	{
		$this->readBase();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			supportsResource($name)
	{
		return ($name === "gallery.xml") ? $this->getCallerContext()->checkRole("Gallery.config") ? 1 : -1 : 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			readBase()
	{
		if (!is_null($this->galleryDoc))
			return;
		$dbFactory = \javax\xml\parsers\DocumentBuilderFactory::newInstance();
		try {
			$dBuilder = $dbFactory->newDocumentBuilder();
			$this->galleryDoc = $dBuilder->parse($this->callerContext->getBeanTyped("resourceResolver", 'net\dryuf\io\ResourceResolver')->getMandatoryResourceAsStream($this->galleryDir."gallery.xml"));
		}
		catch (\javax\xml\parsers\ParserConfigurationException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\org\xml\sax\SAXException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		$this->galleryElement = $this->galleryDoc->documentElement;
		$this->sectionsElement = \net\dryuf\xml\util\DomUtil::getSingleElement($this->galleryElement, "sections");
		$this->isMulti = \net\dryuf\xml\util\DomUtil::getAttributeDefault($this->sectionsElement, "multi", true);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isMulti()
	{
		return $this->isMulti;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			getCurrentSection()
	{
		return $this->currentSection;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public function			getCurrentRecord()
	{
		return $this->currentRecord;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySection>')
	*/
	public function			listSections()
	{
		if (is_null($this->sections)) {
			$this->readBase();
			$this->sections = new \net\dryuf\util\LinkedList();
			$sectionNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($this->sectionsElement, "section");
			for ($i = 0; $i < $sectionNodes->length; $i++) {
				$section = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom($sectionNodes->item($i));
				$this->sections->add($section);
			}
		}
		return $this->sections;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	*/
	public function			listSectionRecords()
	{
		if (is_null($this->currentSection->records)) {
			$this->currentSection->records = new \net\dryuf\util\LinkedList();
			$recordNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($this->currentSection->recordsElement, "record");
			for ($i = 0; $i < $recordNodes->length; $i++) {
				$record = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($this->currentSection, $recordNodes->item($i));
				$record->setRecordCounter($i);
				$this->currentSection->records->add($record);
			}
		}
		return $this->currentSection->records;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySource>')
	*/
	public function			listRecordSources()
	{
		if (is_null($this->currentRecord->sourcesElement))
			return null;
		$sources = new \net\dryuf\util\LinkedList();
		$sourceNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($this->currentRecord->sourcesElement, "source");
		for ($i = 0; $i < $sourceNodes->length; $i++) {
			$source = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySourceDom($this->currentRecord, $sourceNodes->item($i));
			$source->setSourceCounter($i);
			$sources->add($source);
		}
		return $sources;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			setCurrentSectionIdx($idx)
	{
		if (is_null($this->sectionsElement))
			$this->readBase();
		$sectionNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($this->sectionsElement, "section");
		if ($idx >= $sectionNodes->length)
			return $this->currentSection = null;
		return $this->currentSection = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom($sectionNodes->item($idx));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			setCurrentSection($name)
	{
		if (is_null($this->sectionsElement))
			$this->readBase();
		$this->currentSection = null;
		$sectionNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($this->sectionsElement, "section");
		for ($i = 0; $i < $sectionNodes->length; $i++) {
			$sectionElement = $sectionNodes->item($i);
			if (($name === \net\dryuf\xml\util\DomUtil::getAttributeMandatory($sectionElement, "id"))) {
				if (!is_null($this->currentSection))
					throw new \net\dryuf\core\RuntimeException("section name not unique: ".$name);
				$this->currentSection = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom($sectionNodes->item($i));
			}
		}
		if (!is_null($this->currentSection))
			$this->currentSectionName = $this->currentSection->getDisplayName()."/";
		return $this->currentSection;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public function			setCurrentRecord($section, $thumb, $record)
	{
		if (is_null($this->sectionsElement))
			$this->readBase();
		if ($this->isMulti()) {
			if (is_null($this->setCurrentSection($section)))
				return null;
		}
		else {
			$this->setCurrentSectionIdx(0);
		}
		$this->currentRecord = null;
		$recordNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($this->currentSection->recordsElement, "record");
		for ($i = 0; $i < $recordNodes->length; $i++) {
			$recordElement = $recordNodes->item($i);
			if (is_null($thumb) && !is_null(($sourcesElement = \net\dryuf\xml\util\DomUtil::getOptionalElement($recordElement, "sources")))) {
				$sourceNodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($sourcesElement, "source");
				for ($si = 0; $si < $sourceNodes->length; $si++) {
					$sourceElement = $sourceNodes->item($si);
					if (($record === \net\dryuf\xml\util\DomUtil::getAttributeMandatory($sourceElement, "file"))) {
						if (!is_null($this->currentRecord))
							throw new \net\dryuf\core\RuntimeException("record name not unique: ".$record);
						$this->currentRecord = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($this->currentSection, $recordNodes->item($i));
						$this->currentRecord->setRecordCounter($i);
						$this->currentSource = $record;
					}
				}
			}
			else {
				if (($record === \net\dryuf\xml\util\DomUtil::getAttributeMandatory($recordElement, "file"))) {
					if (!is_null($this->currentRecord))
						throw new \net\dryuf\core\RuntimeException("record name not unique: ".$record);
					$this->currentRecord = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom($this->currentSection, $recordNodes->item($i));
					$this->currentRecord->setRecordCounter($i);
					$this->currentSource = null;
				}
			}
		}
		$this->currentThumb = $thumb;
		return $this->currentRecord;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			getSectionByRecord($record)
	{
		return $record->section;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	public function			getSectionDirs()
	{
		return array(
			$this->currentRecord->getSectionPrevious(),
			$this->currentRecord->getSectionNext()
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	public function			getFullDirs()
	{
		return array(
			$this->currentRecord->getFullPrevious(),
			$this->currentRecord->getFullNext()
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getResourceData($name)
	{
		if ($this->supportsResource($name) == 0)
			throw new \net\dryuf\core\RuntimeException("resource unsupported");
		return \net\dryuf\io\FileDataImpl::createFromFilename($this->galleryDir.$name);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadResourceData($name, $data)
	{
		if ($this->supportsResource($name) <= 0)
			throw new \net\dryuf\core\RuntimeException("resource writing unsupported");
		try {
			stream_copy_to_stream($data->getInputStream(), fopen($this->galleryDir.$name, "wb"));
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecordData($input)
	{
		if (!$this->getCallerContext()->checkRole("Gallery.admin"))
			throw new \net\dryuf\core\RuntimeException("denied to upload record");
		try {
			$path = $this->getRecordFullPath(false);
			\net\dryuf\io\DirUtil::mkpath(dirname($path));
			stream_copy_to_stream($input->getInputStream(), fopen($path, "wb"));
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecordThumb($input)
	{
		if (!$this->getCallerContext()->checkRole("Gallery.admin"))
			throw new \net\dryuf\core\RuntimeException("denied to upload record");
		try {
			$path = $this->getRecordFullPath(true);
			\net\dryuf\io\DirUtil::mkpath(dirname($path));
			stream_copy_to_stream($input->getInputStream(), fopen($path, "wb"));
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\File')
	*/
	protected function		getRecordFullPath($isThumb)
	{
		$path = new \net\dryuf\core\StringBuilder($this->galleryDir);
		if ($this->isMulti) {
			if (\net\dryuf\core\StringUtil::indexOf($this->currentSection->getDisplayName(), "/") >= 0)
				throw new \net\dryuf\core\RuntimeException("section name contains '/'");
			if (substr($this->currentSection->getDisplayName(), 0, strlen(".")) == ".")
				throw new \net\dryuf\core\RuntimeException("section name starts with '.'");
			$path->append($this->currentSection->getDisplayName())->append("/");
		}
		if ($isThumb)
			$path->append("thumb/");
		if (\net\dryuf\core\StringUtil::indexOf($this->currentRecord->getDisplayName(), "/") >= 0)
			throw new \net\dryuf\core\RuntimeException("record name contains '/'");
		if (substr($this->currentRecord->getDisplayName(), 0, strlen(".")) == ".")
			throw new \net\dryuf\core\RuntimeException("record name starts with '.'");
		$path->append(!is_null($this->currentSource) ? $this->currentSource : $this->currentRecord->getDisplayName());
		return strval($path);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isMulti = false;

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Document')
	*/
	protected			$galleryDoc;

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	protected			$galleryElement;

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	protected			$sectionsElement;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySection>')
	*/
	protected			$sections;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GallerySectionDom')
	*/
	protected			$currentSection;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\xml\XmlDomGalleryHandler\GalleryRecordDom')
	*/
	protected			$currentRecord;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$currentSource;
};


?>
