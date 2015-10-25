<?php

namespace net\dryuf\mvp;


class StoreServletPresenter extends \net\dryuf\mvp\GenericFilePresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->fileStoreService = $this->getCallerContext()->getBeanTyped($options->getOptionMandatory("fileStoreService"), 'net\dryuf\service\file\FileStoreService');
		if (is_null(($this->basePath = $options->getOptionDefault("basePath", null))))
			$this->basePath = $parentPresenter->getRootPresenter()->getLastElement();
		if (is_null(($this->fileName = $options->getOptionDefault("fileName", null))))
			$this->fileName = $parentPresenter->getRootPresenter()->getLastElement();
		$this->clientName = $options->getOptionDefault("clientName", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getForcedContentType()
	{
		return !is_null($this->clientName) ? $this->getCallerContext()->getBeanTyped("mimeTypeService", 'net\dryuf\text\mime\MimeTypeService')->guessContentTypeFromName($this->clientName) : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	protected function		resolveFileData()
	{
		return $this->fileStoreService->getFile($this->basePath, $this->fileName);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$basePath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$fileName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$clientName;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\file\FileStoreService')
	*/
	protected			$fileStoreService;
};


?>
