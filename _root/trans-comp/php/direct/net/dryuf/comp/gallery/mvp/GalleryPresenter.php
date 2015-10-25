<?php

namespace net\dryuf\comp\gallery\mvp;


class GalleryPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_GALLERY = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_GALLERYSECTION = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_SECTION = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_IMAGE = 3;

	/**
	*/
	function			__construct($parentPresenter, $options, $galleryHandler)
	{
		parent::__construct($parentPresenter, $options);
		if (is_null(($this->galleryHandler = $galleryHandler)))
			throw new \net\dryuf\core\NullPointerException("galleryHandler");
		$this->baseUrl = $options->getOptionDefault("baseUrl", "");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$this->galleryHandler->read();
		if (!$this->galleryHandler->isMulti()) {
			$section = "";
			if (is_null($this->galleryHandler->setCurrentSectionIdx(0)))
				throw new \net\dryuf\core\RuntimeException("unable to set default section");
			return (new \net\dryuf\comp\gallery\mvp\GallerySectionPresenter($this, \net\dryuf\core\Options::$NONE, $section))->process();
		}
		else {
			return parent::process();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		$this->rootPresenter = $this->getRootPresenter();
		if ($this->galleryHandler->supportsResource($element) != 0) {
			if (is_null($this->rootPresenter->needPathSlash(false)))
				return true;
			return (new \net\dryuf\comp\gallery\mvp\GalleryResourcePresenter($this, \net\dryuf\core\Options::$NONE))->process();
		}
		if (is_null($this->rootPresenter->needPathSlash(true)))
			return false;
		if (is_null($this->galleryHandler->setCurrentSection($element))) {
			return $this->createNotFoundPresenter()->process();
		}
		else {
			return (new \net\dryuf\comp\gallery\mvp\GallerySectionPresenter($this, \net\dryuf\core\Options::$NONE, $element))->process();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getMode()
	{
		if (!is_null($this->galleryHandler->getCurrentRecord()))
			return self::MODE_IMAGE;
		elseif (!$this->galleryHandler->isMulti())
			return self::MODE_GALLERYSECTION;
		elseif (!is_null($this->galleryHandler->getCurrentSection()))
			return self::MODE_SECTION;
		else
			return self::MODE_GALLERY;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			injectRenderReference($callback)
	{
		$this->renderReference = $callback;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->renderLeadChild())
			return;
		$this->output("<a name=\"gallery/\"></a><table class=\"net-dryuf-comp-gallery-GalleryPresenter\" width=\"100%\">");
		$this->outputFormat("<tr class=\"reference\"><td colspan='2'>");
		if (!is_null($this->renderReference))
			call_user_func($this->renderReference);
		$this->outputFormat("</td></tr>");
		foreach ($this->galleryHandler->listSections() as $section) {
			$this->outputFormat("<tr class=\"section\"><td><a href=%A>%S</a></td><td>%S</td></tr>", $section->getDisplayName()."/#gallery", $section->getTitle(), $section->getDescription());
		}
		$this->output("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public function			getGalleryHandler()
	{
		return $this->galleryHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	protected			$galleryHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Runnable')
	*/
	public function			getRenderReference()
	{
		return $this->renderReference;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Runnable')
	*/
	protected			$renderReference = null;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getBaseUrl()
	{
		return $this->baseUrl;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$baseUrl;
};


?>
