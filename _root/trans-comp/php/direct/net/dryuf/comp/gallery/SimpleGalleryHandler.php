<?php

namespace net\dryuf\comp\gallery;


abstract class SimpleGalleryHandler extends \net\dryuf\comp\gallery\MemoryGalleryHandler
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
	public function			initFromList($files, $locations)
	{
		$idx = 0;
		$this->read_init();
		$this->currentSection = new \net\dryuf\comp\gallery\MemoryGalleryHandler\GallerySectionMemory();
		$this->currentSection->setDisplayName("");
		$last = null;
		foreach ($files as $file) {
			$p = new \net\dryuf\comp\gallery\MemoryGalleryHandler\GalleryRecordMemory();
			$p->setRecordType(\net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture);
			$p->setTitle($file);
			$p->setDisplayName($file);
			$p->setRecordCounter($idx++);
			$p->setGallerySection($this->currentSection->getPk());
			$p->sectionPrevious = $last;
			$p->fullPrevious = $last;
			if (!is_null($last)) {
				$last->sectionNext = $p;
				$last->fullNext = $p;
			}
			$last = $p;
			$this->read_addRecord($this->currentSection, $p);
		}
		$this->currentSection->setRecordCount($idx);
		$this->read_addSection($this->currentSection);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isMulti()
	{
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySource>')
	*/
	public function			listRecordSources()
	{
		return null;
	}
};


?>
