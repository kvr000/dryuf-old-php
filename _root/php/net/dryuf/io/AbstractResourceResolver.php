<?php

namespace net\dryuf\io;


abstract class AbstractResourceResolver extends \net\dryuf\core\Object implements \net\dryuf\io\ResourceResolver
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public abstract function	getResource($path);

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			getResourceAsStream($path)
	{
		$fileData = $this->getResource($path);
		if (is_null($fileData))
			return null;
		return $fileData->getInputStream();
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			getResourceContent($file)
	{
		$stream = $this->getResourceAsStream($file);
		if (is_null($stream))
			return null;
		try {
			try {
				return stream_get_contents($stream);
			}
			catch (\Exception $ex) {
				fclose($stream);
				throw $ex;
			}
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getMandatoryResource($path)
	{
		$fileData = $this->getResource($path);
		if (is_null($fileData))
			throw new \net\dryuf\core\RuntimeException("Failed to find file within resources: ".$path);
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			getMandatoryResourceAsStream($path)
	{
		$stream = $this->getResourceAsStream($path);
		if (is_null($stream))
			throw new \net\dryuf\core\RuntimeException("Failed to find file within resources: ".$path);
		return $stream;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			getMandatoryResourceContent($path)
	{
		$data = $this->getResourceContent($path);
		if (is_null($data))
			throw new \net\dryuf\core\RuntimeException("Failed to find file within resources: ".$path);
		return $data;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getCacheTimeout($extension)
	{
		return $this->cacheTimeout;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getCompressPolicy($extension)
	{
		return \net\dryuf\io\ResourceResolver::COMPRESS_Unknown;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$cacheTimeout = 86400000;
};


?>
