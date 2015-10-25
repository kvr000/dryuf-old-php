<?php

namespace net\dryuf\mvp\proc;


class ResourcesPresenter extends \net\dryuf\mvp\GenericFilePresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		if (is_null(($this->basePath = $options->getOptionDefault("basePath", null))))
			$this->basePath = $this->getRootPresenter()->getRealPath();
		$resourceResolverName = $options->getOptionDefault("resourceResolverName", "resourceResolver");
		$this->resourceResolver = $this->getCallerContext()->getBeanTyped($resourceResolverName, 'net\dryuf\io\ResourceResolver');
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return $this->processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected function		getCacheTimeout()
	{
		return $this->resourceResolver->getCacheTimeout($this->fileExtension);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getPathInfo()
	{
		$rootPresenter = $this->getRootPresenter();
		$this->urlBase = $rootPresenter->getCurrentPath();
		while (!is_null($rootPresenter->getPathElementSafe())) {
		}
		$currentPath = $rootPresenter->getCurrentPath();
		$this->fileExtension = pathinfo($currentPath, PATHINFO_EXTENSION);
		$fullPath = $this->basePath.strval(substr($currentPath, strlen($this->urlBase)));
		if ($this->resourceResolver->checkFileType($fullPath) == 0) {
			if (is_null($rootPresenter->needPathSlash(true)))
				return null;
			return $this->handlePathDirectory($fullPath);
		}
		return $fullPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		handlePathDirectory($path)
	{
		throw new \net\dryuf\core\RuntimeException("directory listing unsupported");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	protected function		resolveFileData()
	{
		$path = $this->getPathInfo();
		if (is_null($path)) {
			$this->errorReturn = false;
			return null;
		}
		if (is_null(($fileData = $this->resourceResolver->getResource($path))))
			return null;
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		writeFile($fileData)
	{
		parent::writeFile($fileData);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$urlBase;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getUrlBase()
	{
		return $this->urlBase;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$basePath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getBasePath()
	{
		return $this->basePath;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$fileExtension;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFileExtension()
	{
		return $this->fileExtension;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\ResourceResolver')
	*/
	protected			$resourceResolver;
};


?>
