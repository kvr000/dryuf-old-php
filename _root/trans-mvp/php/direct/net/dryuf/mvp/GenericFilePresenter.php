<?php

namespace net\dryuf\mvp;


abstract class GenericFilePresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getForcedContentType()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	protected abstract function	resolveFileData();

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected function		getCacheTimeout()
	{
		return $this->getCallerContext()->getConfigValue("net.dryuf.mvp.cachePeriod", intval(24*3600*1000));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if (is_null(($fileData = $this->resolveFileData()))) {
			if ($this->getResponse()->getCurrentStatus() == 0)
				$this->parentPresenter->createNotFoundPresenter();
			return $this->errorReturn;
		}
		try {
			$this->serveFile($fileData);
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		finally {
			$fileData->close();
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		writeFile($fileData)
	{
		if ($this->rangeStart >= 0) {
			stream_copy_to_stream($fileData->getInputStream(), $this->getResponse()->getOutputStream(), $this->rangeEnd-$this->rangeStart, $this->rangeStart);
		}
		else {
			stream_copy_to_stream($fileData->getInputStream(), $this->getResponse()->getOutputStream());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		serveFile($fileData)
	{
		$request = $this->getRequest();
		$response = $this->getResponse();
		$ifModifiedSince = $request->getDateHeader("If-Modified-Since");
		$range = $request->getHeader("Range");
		if (!is_null($range) && $fileData->getSize() >= 0) {
			if (is_null(($rangeMatch = \net\dryuf\core\StringUtil::matchText("^bytes=(\\d*)-(\\d*)\$", $range))))
				throw new \net\dryuf\core\RuntimeException("Invalid Range header: ".$range);
			$this->rangeStart = $rangeMatch[1] === "" ? -1 : \net\dryuf\core\Dryuf::parseInt($rangeMatch[1]);
			$this->rangeEnd = $rangeMatch[2] === "" ? -1 : \net\dryuf\core\Dryuf::parseInt($rangeMatch[2]);
			if ($this->rangeStart < 0) {
				if ($this->rangeEnd < 0)
					throw new \net\dryuf\core\RuntimeException("Invalid Range header, both start and end are empty: ".$range);
				$this->rangeStart = $fileData->getSize()-$this->rangeEnd;
				$this->rangeEnd = $fileData->getSize();
			}
			elseif ($this->rangeEnd < 0) {
				$this->rangeEnd = $fileData->getSize();
			}
			else {
				++$this->rangeEnd;
			}
			if ($this->rangeStart < 0 || $this->rangeEnd > $fileData->getSize() || $this->rangeStart > $this->rangeEnd) {
				$response->sendStatus(416, "Requested Range Not Satisfiable");
				$response->setHeader("Content-Range", "*/".$fileData->getSize());
				return;
			}
		}
		$modified = $fileData->getModifiedTime();
		if ($ifModifiedSince > 0 && $modified > 0 && $fileData->getModifiedTime() <= $ifModifiedSince) {
			$response->setDateHeader("Last-Modified", $modified);
			$response->sendStatus(304, "Not Modified");
			if (($cachePeriod = $this->getCacheTimeout()) > 0) {
				$response->setHeader("Cache-Control", "max-age=".intval($cachePeriod/1000));
				$response->setDateHeader("Expires", intval(microtime(true)*1000)+$cachePeriod);
			}
			return;
		}
		else {
			$contentType = $this->getForcedContentType();
			if (is_null($contentType) && is_null(($contentType = $fileData->getContentType())))
				$contentType = "application/octet-stream";
			$response->setContentType($contentType);
			$size = $fileData->getSize();
			if ($this->rangeStart >= 0) {
				$response->setHeader("Content-Range", "bytes ".$this->rangeStart."-".($this->rangeEnd-1)."/".$size);
				$response->setLongHeader("Content-Length", $this->rangeEnd-$this->rangeStart);
			}
			elseif ($size >= 0) {
				$response->setLongHeader("Content-Length", $size);
			}
			if (($cachePeriod = $this->getCacheTimeout()) > 0) {
				$response->setHeader("Cache-Control", "max-age=".intval($cachePeriod/1000));
				$response->setDateHeader("Expires", intval(microtime(true)*1000)+$cachePeriod);
			}
			if ($modified >= 0)
				$response->setDateHeader("Last-Modified", $modified);
			if (!($this->getRequest()->getMethod() === "HEAD"))
				$this->writeFile($fileData);
		}
	}

	/**
	 * start of range header (or -1)  */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$rangeStart = -1;

	/**
	 * end of range header (or -1)  */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$rangeEnd = -1;

	/**
	 * force return value from process  */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$errorReturn = true;
};


?>
