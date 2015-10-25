<?php

namespace net\dryuf\comp\gallery\mvp;


class GalleryAddFormPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $galleryHandler)
	{
		parent::__construct($parentPresenter, $options);
		$this->galleryHandler = $galleryHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if (is_null($this->getCallerContext()->getUserId())) {
			new \net\dryuf\mvp\NeedLoginPresenter($this->parentPresenter, \net\dryuf\core\Options::buildListed("messageClass", 'net\dryuf\comp\gallery\mvp\GalleryAddFormPresenter', "message", "You need to --login-- to add pictures"));
		}
		return parent::process();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if (is_null($this->getCallerContext()->getUserId())) {
			$this->renderLeadChild();
		}
		else {
			parent::render();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performAdd($action)
	{
		$galleryAddForm = $this->getBackingObject();
		$galleryAddForm->setPicture(\net\dryuf\text\util\TextUtil::convertNameToDisplay($galleryAddForm->getPicture()));
		$galleryRecord = new \net\dryuf\comp\gallery\GalleryRecord();
		if (!$this->galleryHandler->addRecord($galleryRecord, $this->getRequest()->getFile($this->getFormFieldName("picture")."File"))) {
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, 'net\dryuf\comp\gallery\mvp\GalleryAddFormPresenter', "Picture of the same name already exists");
		}
		else {
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\comp\gallery\mvp\GalleryAddFormPresenter', "Picture added");
		}
		$this->getRootPresenter()->getResponse()->redirect(".");
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\form\GalleryAddForm')
	*/
	public function			createBackingObject()
	{
		return new \net\dryuf\comp\gallery\form\GalleryAddForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	protected			$galleryHandler;
};


?>
