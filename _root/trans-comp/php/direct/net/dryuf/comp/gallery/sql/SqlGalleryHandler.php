<?php

namespace net\dryuf\comp\gallery\sql;


class SqlGalleryHandler extends \net\dryuf\comp\gallery\GenericGalleryHandler
{
	/**
	*/
	function			__construct($galleryBo, $galleryHeaderHolder)
	{
		parent::__construct($galleryHeaderHolder->getRole());
		$this->galleryBo = $galleryBo;
		$this->galleryRecordDao = $galleryBo->getGalleryRecordDao();
		$this->gallerySectionDao = $galleryBo->getGallerySectionDao();
		$this->galleryHeaderDao = $galleryBo->getGalleryHeaderDao();
		$this->galleryHeaderHolder = $galleryHeaderHolder;
		$this->galleryHeader = $galleryHeaderHolder->getEntity();
		$this->isMulti = $this->galleryHeader->getIsMulti();
		$this->width = $this->galleryHeader->getMaxWidth();
		$this->height = $this->galleryHeader->getMaxHeight();
		$this->thumbScale = $this->galleryHeader->getThumbScale();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deleteGallery()
	{
		$this->cleanGallery();
		$this->galleryHeaderDao->remove($this->galleryHeader);
		if (!\net\dryuf\core\StringUtil::matchRegExp($this->galleryHeader->getDisplayName(), "^[-_a-zA-Z0-9]+\$"))
			throw new \net\dryuf\core\RuntimeException("gallery has invalid characters: ".$this->galleryHeader->getDisplayName());
		$this->galleryBo->getGalleryStoreService()->removePath(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\SqlGalleryHandler')."/".$this->galleryHeader->getGalleryId()."/");
		$this->galleryHeader = null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanGallery()
	{
		$this->gallerySectionDao->runTransactionedSafe(
			function () {
				foreach ($this->listSections() as $section) {
					$this->currentSection = $section;
					$this->deleteSection();
				}
				return null;
			}
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			updateSection()
	{
		$this->gallerySectionDao->updateSectionStats($this->currentSection->getPk());
		$this->updateHeader();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			updateHeader()
	{
		$this->galleryHeaderDao->updateHeaderStats($this->galleryHeader->getGalleryId());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecordData($content)
	{
		$this->galleryBo->getGalleryStoreService()->putFile(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\SqlGalleryBo')."/".$this->galleryHeader->getGalleryId()."/".$this->buildPath($this->currentSection->getDisplayName(), null), $this->validateRecordPath($this->currentRecord->getDisplayName()), $content);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecordThumb($content)
	{
		$this->galleryBo->getGalleryStoreService()->putFile(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\SqlGalleryBo')."/".$this->galleryHeader->getGalleryId()."/".$this->buildPath($this->currentSection->getDisplayName(), "thumb/"), $this->validateRecordPath($this->currentRecord->getDisplayName()), $content);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getRecordData($record)
	{
		return $this->galleryBo->getGalleryStoreService()->getFile(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\SqlGalleryBo')."/".$this->galleryHeader->getGalleryId()."/".$this->buildPath($this->currentSection->getDisplayName(), null), $this->validateRecordPath($this->currentRecord->getDisplayName()));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getRecordThumb($record)
	{
		return $this->galleryBo->getGalleryStoreService()->getFile(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\SqlGalleryBo')."/".$this->galleryHeader->getGalleryId()."/".$this->buildPath($this->currentSection->getDisplayName(), "thumb/"), $this->validateRecordPath($this->currentRecord->getDisplayName()));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isMulti()
	{
		return $this->isMulti;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			read()
	{
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
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			getSectionByRecord($record)
	{
		throw new \net\dryuf\core\RuntimeException("TODO");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			addSection($section)
	{
		$lastFailed = -1;
		for (;;) {
			$counter = $this->gallerySectionDao->getMaxSectionCounter($this->galleryHeader->getGalleryId());
			if (is_null($counter))
				$counter = 0;
			else
				++$counter;
			$section->setGalleryId($this->galleryHeader->getGalleryId());
			$section->setSectionCounter($counter);
			try {
				$this->gallerySectionDao->insertTxNew($section);
				return true;
			}
			catch (\net\dryuf\dao\DaoPrimaryKeyConstraintException $ex) {
				if ($counter == $lastFailed)
					throw $ex;
				$lastFailed = $counter;
				return false;
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deleteSection()
	{
		foreach ($this->listSectionRecords() as $record) {
			$this->currentRecord = $record;
			$this->deleteRecord();
		}
		$this->galleryBo->getGalleryStoreService()->removePath($this->buildPath($this->currentSection->getDisplayName(), null));
		$this->gallerySectionDao->removeByPk($this->currentSection->getPk());
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			addRecord($record, $imageContent)
	{
		try {
			$resized = $this->getImageResizeService()->resizeToMaxWh(stream_get_contents($imageContent->getInputStream()), $this->width, $this->height, true, pathinfo($imageContent->getName(), PATHINFO_EXTENSION));
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		if (is_null($this->currentSection))
			throw new \net\dryuf\core\NullPointerException("currentSection");
		$name = $this->validateRecordPath($imageContent->getName());
		$path = $this->buildPath($this->currentSection->getDisplayName(), null);
		$thumb = $this->buildPath($this->currentSection->getDisplayName(), "thumb");
		$lastFailed = -1;
		for (;;) {
			$counter = $this->galleryRecordDao->getMaxRecordCounter($this->currentSection->getPk());
			if (is_null($counter))
				$counter = 0;
			else
				++$counter;
			$record->setRecordCounter($counter);
			$record->setGallerySection($this->getCurrentSection()->getPk());
			if (is_null($record->getCreated()))
				$record->setCreated(intval(microtime(true)*1000));
			try {
				$this->galleryRecordDao->insertTxNew($record);
				break;
			}
			catch (\net\dryuf\dao\DaoPrimaryKeyConstraintException $ex) {
				if ($counter == $lastFailed)
					throw $ex;
				$lastFailed = $counter;
				return false;
			}
		}
		$this->getGalleryStoreService()->putFile($path, $name, \net\dryuf\io\FileDataImpl::createFromNameBytes($name, $resized));
		$this->getGalleryStoreService()->putFile($thumb, $name, \net\dryuf\io\FileDataImpl::createFromNameBytes($name, $this->getImageResizeService()->resizeScale($resized, $this->thumbScale, true, pathinfo($imageContent->getName(), PATHINFO_EXTENSION))));
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deleteRecord()
	{
		$fname = $this->validateRecordPath($this->currentRecord->getDisplayName());
		$path = $this->buildPath($this->currentSection->getDisplayName(), null);
		$thumb = $this->buildPath($this->currentSection->getDisplayName(), "thumb");
		$this->getGalleryStoreService()->removeFile($path, $fname);
		$this->getGalleryStoreService()->removeFile($thumb, $fname);
		$this->galleryRecordDao->remove($this->currentRecord);
		$this->updateSection();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySection>')
	*/
	public function			listSections()
	{
		return $this->gallerySectionDao->listByCompos($this->galleryHeader->getGalleryId());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	*/
	public function			listSectionRecords()
	{
		return $this->galleryRecordDao->listByCompos($this->currentSection->getPk());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySource>')
	*/
	public function			listRecordSources()
	{
		return $this->gallerySourceDao->listByCompos($this->currentRecord->getPk());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			setCurrentSectionIdx($sectionIndex)
	{
		return $this->currentSection = $this->gallerySectionDao->loadByPk(new \net\dryuf\comp\gallery\GallerySection\Pk($this->galleryHeader->getGalleryId(), $sectionIndex));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			setCurrentSection($sectionName)
	{
		return $this->currentSection = $this->gallerySectionDao->loadByDisplay($this->galleryHeader->getGalleryId(), $sectionName);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public function			setCurrentRecord($section, $thumb, $record)
	{
		if ($this->isMulti) {
			if (is_null($this->setCurrentSection($section)))
				return null;
		}
		$this->currentThumb = $thumb;
		return $this->currentRecord = $this->galleryRecordDao->loadByDisplay($this->currentSection->getPk(), $record);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	public function			loadSection($sectionCounter)
	{
		return $this->gallerySectionDao->loadByPk(new \net\dryuf\comp\gallery\GallerySection\Pk($this->getGalleryId(), $sectionCounter));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	public function			getSectionDirs()
	{
		$older = $this->galleryRecordDao->loadSectionedPrevious($this->currentRecord->getPk());
		$newer = $this->galleryRecordDao->loadSectionedNext($this->currentRecord->getPk());
		return array(
			$older,
			$newer
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	public function			getFullDirs()
	{
		$older = $this->galleryRecordDao->loadFullPrevious($this->currentRecord->getPk());
		$newer = $this->galleryRecordDao->loadFullNext($this->currentRecord->getPk());
		return array(
			$older,
			$newer
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		validateRecordPath($displayName)
	{
		if (!\net\dryuf\core\StringUtil::matchRegExp($displayName, "^[-_a-zA-Z0-9.]+\$"))
			throw new \net\dryuf\core\RuntimeException("record has invalid characters: ".$displayName);
		return $displayName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		buildPath($sectionDisplayName, $thumbPath)
	{
		$path = new \net\dryuf\core\StringBuilder(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\gallery\sql\SqlGalleryHandler')."/".$this->galleryHeader->getGalleryId()."/");
		if (!\net\dryuf\core\StringUtil::matchRegExp($sectionDisplayName, "^[-_a-zA-Z0-9]+\$"))
			throw new \net\dryuf\core\RuntimeException("section has invalid characters: ".$sectionDisplayName);
		if (!is_null($thumbPath) && !\net\dryuf\core\StringUtil::matchRegExp($thumbPath, "^[-_a-zA-Z0-9]+\$"))
			throw new \net\dryuf\core\RuntimeException("thumbPath has invalid characters: ".$thumbPath);
		if ($this->isMulti)
			$path->append($sectionDisplayName)->append("/");
		if (!is_null($thumbPath))
			$path->append($thumbPath)->append("/");
		return strval($path);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCurrentRecordPath($innerDir)
	{
		throw new \net\dryuf\core\RuntimeException("TODO");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\image\ImageResizeService')
	*/
	protected function		getImageResizeService()
	{
		return $this->galleryBo->getImageResizeService();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\file\FileStoreService')
	*/
	protected function		getGalleryStoreService()
	{
		return $this->galleryBo->getGalleryStoreService();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected function		getGalleryId()
	{
		return $this->galleryHeader->getGalleryId();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	public				$galleryHeaderHolder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	public				$galleryHeader;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	protected			$currentSection;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	protected			$currentRecord;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$currentThumb;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isMulti = false;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$width = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$height = 0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	protected			$thumbScale = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\sql\SqlGalleryBo')
	*/
	protected			$galleryBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GalleryHeaderDao')
	*/
	protected			$galleryHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GallerySectionDao')
	*/
	protected			$gallerySectionDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GalleryRecordDao')
	*/
	protected			$galleryRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GallerySourceDao')
	*/
	protected			$gallerySourceDao;
};


?>
