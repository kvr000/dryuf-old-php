<?php

namespace net\dryuf\mvp\proc;


abstract class GenericExport extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parent_presenter, $options)
	{
		parent::__construct($parent_presenter, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return $this->processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPathInfo()
	{
		$this->basepath = $this->getRootPresenter()->getCurrentPath();
		while (!is_null($this->getRootPresenter()->getPathElement())) {
		}
		return strval(substr($this->getRootPresenter()->getCurrentPath(), strlen($this->basepath)));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$file = $this->getPathInfo();
		$this->rootPresenter->setLeadChild($this);
		try {
			$modinfo = new \net\dryuf\mvp\proc\GenericExport\ModifiedInfo();
			if (!is_null(($content = $this->prepareData($file, $modinfo)))) {
				$response = $this->getRootPresenter()->getResponse();
				$response->setContentType($this->getMimeType());
				stream_copy_to_stream($content, $response->getOutputStream());
			}
			else {
				$this->reportNotFound();
			}
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			reportError($code, $msg)
	{
		$this->getRootPresenter()->getResponse()->sendError($code, $msg);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			reportNotFound()
	{
		$this->getRootPresenter()->getResponse()->sendError(404, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getNotModifiedSince()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	getMimeType();

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public abstract function	prepareData($file, $modified);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$basepath;
};


?>
