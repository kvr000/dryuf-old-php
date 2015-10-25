<?php

namespace net\dryuf\comp\gallery\mvp;


class GallerySectionPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $section)
	{
		parent::__construct($parentPresenter, $options);
		$this->galleryPresenter = $parentPresenter;
		if (is_null(($this->galleryHandler = $this->galleryPresenter->getGalleryHandler())))
			throw new \net\dryuf\core\NullPointerException("galleryHandler");
		$this->renderReference = $this->galleryPresenter->getRenderReference();
		$this->baseUrl = $this->galleryPresenter->getBaseUrl();
		$this->section = $section;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		$this->rootPresenter = $this->getRootPresenter();
		if (!is_null(($match = \net\dryuf\core\StringUtil::matchText("^(.*)\\.html\$", $element)))) {
			$image = $match[1];
			if (is_null($this->rootPresenter->needPathSlash(false)))
				return true;
			if (is_null($this->galleryHandler->setCurrentRecord($this->section, null, $image))) {
				return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\mvp\NotFoundPresenter', $this, \net\dryuf\core\Options::buildListed("content", $this->localize('net\dryuf\comp\gallery\mvp\GallerySectionPresenter', "Requested picture not found, please go back to <a href=\"+/\">gallery section</a>")))->process();
			}
			return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', $this, \net\dryuf\core\Options::$NONE)->process();
		}
		else {
			$thumb = null;
			if (($element === "thumb")) {
				$thumb = $element."/";
			}
			if (!is_null($thumb)) {
				if (is_null($this->rootPresenter->needPathSlash(true)))
					return false;
				$element = $this->rootPresenter->getPathElement();
			}
			if (!is_null($this->galleryHandler->setCurrentRecord($this->section, $thumb, $element))) {
				if (is_null($this->rootPresenter->needPathSlash(false)))
					return true;
				return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\comp\gallery\mvp\GallerySectionFilePresenter', $this, \net\dryuf\core\Options::buildListed("thumb", $thumb))->process();
			}
			return $this->createDefaultPresenter()->process();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->renderLeadChild())
			return;
		$this->output("<table width=\"100%\"><tr width=\"100%\">");
		if ($this->galleryHandler->isMulti()) {
			$this->outputFormat("<td><a href=\"../#gallery\">%W</a></td><td align='right'>", 'net\dryuf\comp\gallery\mvp\GallerySectionPresenter', "Back to gallery");
			if (!is_null($this->renderReference))
				call_user_func($this->renderReference);
			$this->output("</td>");
		}
		else {
			$this->output("<td></td><td align='center'>");
			if (!is_null($this->renderReference))
				call_user_func($this->renderReference);
			$this->output("</td>");
		}
		$this->output("</tr><tr><td colspan='2'>");
		foreach ($this->galleryHandler->listSectionRecords() as $picture) {
			$this->outputFormat("<a href=%A><img alt=%A src=%A /></a> ", $picture->getDisplayName().".html#gallery", $picture->getTitle(), $this->baseUrl."thumb/".$picture->getDisplayName());
		}
		$this->output("</td></tr></table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\mvp\GalleryPresenter')
	*/
	protected			$galleryPresenter;

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
	protected			$renderReference;

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

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSection()
	{
		return $this->section;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$section;

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
};


?>
