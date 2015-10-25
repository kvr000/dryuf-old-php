<?php

namespace net\dryuf\comp\gallery\mvp;


class GallerySectionRecordPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->gallerySectionPresenter = $parentPresenter;
		if (is_null(($this->galleryHandler = $this->gallerySectionPresenter->getGalleryHandler())))
			throw new \net\dryuf\core\NullPointerException("galleryHandler");
		$this->renderReference = $this->gallerySectionPresenter->getRenderReference();
		$this->baseUrl = $this->gallerySectionPresenter->getBaseUrl();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->renderLeadChild())
			return;
		$currentSection = $this->galleryHandler->getCurrentSection();
		$currentRecord = $this->galleryHandler->getCurrentRecord();
		$this->output("<table width=\"100%\">\n\t<tr>");
		$this->outputFormat("<td width=\"33%%\" align='left'>%W: %S / %S</td>", 'net\dryuf\comp\gallery\mvp\GallerySectionPresenter', "Image", strval($currentRecord->getRecordCounter()+1), strval($currentSection->getRecordCount()));
		$this->output("<td width=\"34%\" align='center'>");
		$sectionDirs = $this->galleryHandler->getSectionDirs();
		$fullDirs = $this->galleryHandler->isMulti() ? $this->galleryHandler->getFullDirs() : $sectionDirs;
		if (!is_null($sectionDirs[0])) {
			$this->outputFormat("<a href=%A>%W</a>", \net\dryuf\net\util\UrlUtil::encodeUrl($sectionDirs[0]->getDisplayName()).".html#gallery", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Previous");
		}
		elseif (!is_null($fullDirs[0])) {
			$this->outputFormat("<a href=%A>%W</a>", "../".\net\dryuf\net\util\UrlUtil::encodeUrl($this->galleryHandler->getSectionByRecord($fullDirs[0])->getDisplayName())."/".\net\dryuf\net\util\UrlUtil::encodeUrl($fullDirs[0]->getDisplayName()).".html#gallery", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Previous");
		}
		else {
			$this->outputFormat("%W", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Previous");
		}
		if ($this->galleryHandler->isMulti())
			$this->outputFormat(" <a name=\"gallery\"></a><a href=\".\">%S</a> ", $currentSection->getTitle());
		else
			$this->outputFormat(" <a name=\"gallery\"></a><a href=\".\">%W</a> ", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Album");
		if (!is_null($sectionDirs[1])) {
			$this->outputFormat("<a href=%A>%W</a>", \net\dryuf\net\util\UrlUtil::encodeUrl($sectionDirs[1]->getDisplayName()).".html#gallery", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Next");
		}
		elseif (!is_null($fullDirs[1])) {
			$this->outputFormat("<a href=%A>%W</a>", "../".\net\dryuf\net\util\UrlUtil::encodeUrl($this->galleryHandler->getSectionByRecord($fullDirs[1])->getDisplayName())."/".\net\dryuf\net\util\UrlUtil::encodeUrl($fullDirs[1]->getDisplayName()).".html#gallery", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Next");
		}
		else {
			$this->outputFormat("%W", 'net\dryuf\comp\gallery\mvp\GallerySectionRecordPresenter', "Next");
		}
		$this->outputFormat("</td><td width=\"33%%\" align='center'>");
		if (!is_null($this->renderReference))
			call_user_func($this->renderReference);
		$this->outputFormat("</td></tr>\n");
		$this->outputFormat("\t<tr><td colspan='3'>\n");
		switch ($currentRecord->getRecordType()) {
		case \net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Picture:
			$this->outputFormat("\t\t<img alt=%A src=%A />", $currentRecord->getTitle(), $this->baseUrl.\net\dryuf\net\util\UrlUtil::encodeUrl($currentRecord->getDisplayName()));
			break;

		case \net\dryuf\comp\gallery\GalleryRecord\RecordType::RT_Video:
			$this->outputFormat("\t\t<video controls>\n", $currentRecord->getTitle(), $this->baseUrl.\net\dryuf\net\util\UrlUtil::encodeUrl($currentRecord->getDisplayName()));
			foreach ($this->galleryHandler->listRecordSources() as $source) {
				$this->outputFormat("\t\t\t<source src=%A type=%A />\n", $source->getDisplayName(), $source->getMimeType());
			}
			$this->outputFormat("\t\t</video>\n");
			break;

		default:
			$this->outputFormat("\t\t<div class='msg_type_400'>Unknown gallery record type: %S</div>\n", strval($currentRecord->getRecordType()));
			/* fall through */
		}
		$this->outputFormat("\t</td></tr>\n");
		$this->outputFormat("\t<tr><td colspan='3'>%S</td></tr>\n", !is_null($currentRecord->getDescription()) ? $currentRecord->getDescription() : $currentRecord->getTitle());
		$this->output("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\mvp\GallerySectionPresenter')
	*/
	protected			$gallerySectionPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	protected			$galleryHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Runnable')
	*/
	protected			$renderReference;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$baseUrl;
};


?>
