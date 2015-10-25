<?php

namespace net\dryuf\comp\gallery\mvp;


abstract class CommonMultiGalleryPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		if (is_null(($this->store = $options->getOptionDefault("store", null))))
			$this->store = $this->getRootPresenter()->getCurrentPath();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		if (is_null(($page = $this->getPathGallery()))) {
			return $this->processNoGallery();
		}
		elseif (($page === "")) {
			return false;
		}
		else {
			$galleryPresenter = new \net\dryuf\comp\gallery\mvp\GalleryPresenter($this, \net\dryuf\core\Options::$NONE, $this->openGalleryHandler($page));
			$galleryPresenter->injectRenderReference(
				function () {
					$this->renderGalleryReference();
				}
			);
		}
		return parent::process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processNoGallery()
	{
		return $this->processFinal();
	}

	/**
	 * Gets gallery path.
	 * 
	 * @return null
	 * 	if there was no path passed
	 * @return ""
	 * 	if redirect is required due to missing slash
	 * @return path with slash at the end
	 * 	if gallery was passed
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPathGallery()
	{
		if (!is_null(($page = $this->getRootPresenter()->getPathElement()))) {
			if (is_null($this->getRootPresenter()->needPathSlash(true)))
				return "";
			if (is_null(\net\dryuf\core\StringUtil::matchText("^([a-zA-Z0-9][-0-9A-Za-z_]*)\$", $page)))
				throw new \net\dryuf\core\ReportException("wrong page");
			return $page."/";
		}
		return null;
	}

	/**
	 * Opens gallery handler.
	 * 
	 * @param page
	 * 	the last element in path
	 * 
	 * @return null
	 * 	if there was no path passed
	 * @return gallery handler
	 * 	if found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public abstract function	openGalleryHandler($page);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderGalleryReference()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		parent::render();
		if (is_null($this->getLeadChild())) {
			$this->renderGalleries();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderGalleries()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$store;
};


?>
