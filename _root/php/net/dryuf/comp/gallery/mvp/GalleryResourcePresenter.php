<?php

namespace net\dryuf\comp\gallery\mvp;


class GalleryResourcePresenter extends \net\dryuf\mvp\GenericFilePresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->galleryPresenter = $parentPresenter;
		if (is_null(($this->galleryHandler = $this->galleryPresenter->getGalleryHandler())))
			throw new \net\dryuf\core\NullPointerException("galleryHandler");
		$this->renderReference = $this->galleryPresenter->getRenderReference();
		$this->baseUrl = $this->galleryPresenter->getBaseUrl();
		$this->resourceName = $this->getRootPresenter()->getLastElement();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	protected function		resolveFileData()
	{
		return $this->galleryHandler->getResourceData($this->resourceName);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processPut()
	{
		if ($this->galleryHandler->supportsResource($this->resourceName) < 0) {
			return $this->createUnallowedMethodPresenter()->process();
		}
		$this->galleryHandler->uploadResourceData($this->resourceName, \net\dryuf\io\FileDataImpl::createFromStream($this->getRootPresenter()->getRequest()->getInputStream()));
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\mvp\GalleryPresenter')
	*/
	protected			$galleryPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\mvp\GalleryPresenter')
	*/
	public function			getGalleryPresenter()
	{
		return $this->galleryPresenter;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Runnable')
	*/
	protected			$renderReference;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Runnable')
	*/
	public function			getRenderReference()
	{
		return $this->renderReference;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$baseUrl;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getBaseUrl()
	{
		return $this->baseUrl;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	protected			$galleryHandler;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public function			getGalleryHandler()
	{
		return $this->galleryHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$resourceName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getResourceName()
	{
		return $this->resourceName;
	}
};


?>
