<?php

namespace net\dryuf\mvp\proc;


abstract class CachedExport extends \net\dryuf\mvp\proc\GenericExport
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$file = $this->getPathInfo();
		$modinfo = new \net\dryuf\mvp\proc\GenericExport\ModifiedInfo();
		$webResponse = $this->getRootPresenter()->getResponse();
		if (!is_null(($content = $this->prepareData($file, $modinfo)))) {
			$webResponse->setContentType($this->getMimeType());
			try {
				stream_copy_to_stream($content, $webResponse->getOutputStream());
			}
			catch (\net\dryuf\io\IoException $ex) {
				throw new \net\dryuf\core\RuntimeException($ex);
			}
		}
		else {
			if (is_null($modinfo->modified)) {
				$this->reportNotFound();
			}
			else {
				$webResponse->sendError(304, "Not Modified");
			}
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			getCached($subid, $obj_name, $ext, $modinfo)
	{
		return $this->buildData($subid, $obj_name, $ext);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public abstract function	buildData($subid, $obj_name, $ext);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public				$nocache = false;
};


?>
