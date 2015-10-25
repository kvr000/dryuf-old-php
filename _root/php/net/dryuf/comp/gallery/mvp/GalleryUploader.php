<?php

namespace net\dryuf\comp\gallery\mvp;


class GalleryUploader extends \net\dryuf\srvui\UiBased
{
	/**
	*/
	function			__construct($callerContext, $options, $galleryHandler)
	{
		parent::__construct($callerContext);
		if (is_null(($this->galleryHandler = $galleryHandler)))
			throw new \net\dryuf\core\NullPointerException("galleryHandler");
		if (!(substr(($this->targetUrl = $options->getOptionMandatory("targetUrl")), -strlen("/")) == "/"))
			throw new \net\dryuf\core\RuntimeException("targetUrl must end with '/'");
		$this->sid = $options->getOptionMandatory("sid");
		$this->galleryHandler->read();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadResources()
	{
		try {
			\net\dryuf\io\HttpUtil::putRaw($this->targetUrl."gallery.xml", "text/xml", stream_get_contents($this->galleryHandler->getResourceData("gallery.xml")->getInputStream()), 
				array( "cookie",
					"PHPSESSID=".$this->sid
				));
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadData()
	{
		foreach ($this->galleryHandler->listSections() as $section) {
			$this->uploadSection($section->getDisplayName());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadSection($sectionName)
	{
		if (is_null($this->galleryHandler->setCurrentSection($sectionName)))
			throw new \net\dryuf\core\RuntimeException("unable to set ".$sectionName);
		foreach ($this->galleryHandler->listSectionRecords() as $picture) {
			$this->uploadRecord($sectionName, $picture->getDisplayName());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecord($sectionName, $pictureName)
	{
		if (is_null($this->galleryHandler->setCurrentRecord($sectionName, null, $pictureName)))
			throw new \net\dryuf\core\RuntimeException("unable to set ".$sectionName."/".$pictureName);
		$subPath = ($this->galleryHandler->isMulti() ? $sectionName."/" : "").$pictureName;
		$thumbPath = ($this->galleryHandler->isMulti() ? $sectionName."/" : "")."thumb/".$pictureName;
		try {
			\net\dryuf\io\HttpUtil::putRaw($this->targetUrl.$subPath, "image/jpeg", file_get_contents($subPath), 
				array( "cookie",
					"PHPSESSID=".$this->sid
				));
			\net\dryuf\io\HttpUtil::putRaw($this->targetUrl.$thumbPath, "image/jpeg", file_get_contents($thumbPath), 
				array( "cookie",
					"PHPSESSID=".$this->sid
				));
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	protected			$galleryHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$targetUrl;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$sid;
};


?>
