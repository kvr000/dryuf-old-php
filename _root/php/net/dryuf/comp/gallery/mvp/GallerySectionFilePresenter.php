<?php

namespace net\dryuf\comp\gallery\mvp;


class GallerySectionFilePresenter extends \net\dryuf\mvp\GenericFilePresenter
{
	/**
	*/
	function			__construct(\net\dryuf\mvp\Presenter $parentPresenter, \net\dryuf\core\Options $options)
	{
		parent::__construct($parentPresenter, $options);
		if (is_null(($this->galleryHandler = $parentPresenter->getGalleryHandler())))
			throw new \net\dryuf\core\NullPointerException("galleryHandler");
		$this->thumb = $options->getOptionDefault("thumb", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			resolveFileData()
	{
		if (is_null($this->thumb)) {
			return $this->galleryHandler->getRecordData($this->galleryHandler->getCurrentRecord());
		}
		else {
			return $this->galleryHandler->getRecordThumb($this->galleryHandler->getCurrentRecord());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processPut()
	{
		$rootPresenter = $this->getRootPresenter();
		$input = $rootPresenter->getRequest()->getInputStream();
		if (!$this->galleryHandler->getCallerContext()->checkRole("Gallery.admin")) {
			$this->parentPresenter->createDeniedPresenter();
			return true;
		}
		if (is_null($this->thumb)) {
			$this->galleryHandler->uploadRecordData(\net\dryuf\io\FileDataImpl::createFromNameStream($this->galleryHandler->getCurrentRecord()->getDisplayName(), $input));
		}
		else {
			$this->galleryHandler->uploadRecordThumb(\net\dryuf\io\FileDataImpl::createFromStream($input));
		}
		$rootPresenter->redirect(\net\dryuf\srvui\PageUrl::createFinal($rootPresenter->getFullUrl()));
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	protected			$galleryHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$thumb;
};


?>
