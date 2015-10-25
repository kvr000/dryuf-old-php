<?php

namespace net\dryuf\comp\gallery;


abstract class MemoryGalleryHandler extends \net\dryuf\comp\gallery\ReadonlyGalleryHandler
{
	/**
	*/
	function			__construct($callerContext, $galleryDir)
	{
		$this->sectionsHash = new \net\dryuf\util\php\StringNativeHashMap();
		$this->sectionsCounterHash = new \net\dryuf\util\php\NativeHashMap();

		parent::__construct($callerContext, $galleryDir);
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
		$this->read();
		return $this->sections;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	*/
	public function			listSectionRecords()
	{
		$this->read();
		return $this->currentSection->records;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			setCurrentSectionIdx($idx)
	{
		if ($idx >= $this->sections->size())
			return null;
		return $this->currentSection = $this->sections->get($idx);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			setCurrentSection($name)
	{
		if (!is_null(($this->currentSection = $this->sectionsHash->get($name))))
			$this->currentSectionName = $this->currentSection->getDisplayName()."/";
		return $this->currentSection;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public function			setCurrentRecord($section, $thumb, $record)
	{
		$this->read();
		if ($this->isMulti()) {
			if (is_null($this->setCurrentSection($section)))
				return null;
		}
		else {
			$this->setCurrentSectionIdx(0);
		}
		$this->currentThumb = $thumb;
		return $this->currentRecord = $this->currentSection->recordsHash->get($record);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			getSectionByRecord($record)
	{
		return $this->sectionsCounterHash->get($record->getGallerySection()->getSectionCounter());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	public function			getSectionDirs()
	{
		return array(
			$this->currentRecord->sectionPrevious,
			$this->currentRecord->sectionNext
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	public function			getFullDirs()
	{
		return array(
			$this->currentRecord->fullPrevious,
			$this->currentRecord->fullNext
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		read_init()
	{
		$this->sections = new \net\dryuf\util\LinkedList();
		$this->locationsHash = new \net\dryuf\util\php\StringNativeHashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		read_addSection($section)
	{
		if (!is_null($this->sectionsHash->get($section->getDisplayName())))
			throw new \net\dryuf\core\ReportException("section name ".$section->getDisplayName()." not unique ".$this->sectionsHash);
		$this->sections->add($section);
		$this->sectionsHash->put($section->getDisplayName(), $section);
		$this->sectionsCounterHash->put($section->getSectionCounter(), $section);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		read_addRecord($section, $record)
	{
		if (!is_null($section->recordsHash->get($record->getDisplayName())))
			throw new \net\dryuf\core\ReportException("record ".$section->getDisplayName()."/".$record->getDisplayName()." not unique");
		$section->records->add($record);
		$section->recordsHash->put($record->getDisplayName(), $record);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\MemoryGalleryHandler\GallerySectionMemory')
	*/
	protected			$currentSection;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\MemoryGalleryHandler\GalleryRecordMemory')
	*/
	protected			$currentRecord;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$currentThumb;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySection>')
	*/
	public				$sections;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\comp\gallery\GallerySection>')
	*/
	public				$sectionsHash;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Long, net\dryuf\comp\gallery\MemoryGalleryHandler\GallerySectionMemory>')
	*/
	public				$sectionsCounterHash;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\comp\gallery\GalleryLocation>')
	*/
	public				$locationsHash;
};


?>
