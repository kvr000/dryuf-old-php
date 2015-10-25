<?php

namespace net\dryuf\io;


class FileDataImpl extends \net\dryuf\core\Object implements \net\dryuf\io\FileData
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileDataImpl')
	*/
	public static function		createFromFile($filename)
	{
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->name = $filename;
		$fileData->size = filesize($filename);
		$fileData->modifiedTime = filemtime($filename)*1000;
		$fileData->inputStream = fopen($filename, "rb");
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileDataImpl')
	*/
	public static function		createFromFilename($filename)
	{
		return \net\dryuf\io\FileDataImpl::createFromFile($filename);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileDataImpl')
	*/
	public static function		createFromNameStream($name, $stream)
	{
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->name = $name;
		$fileData->inputStream = $stream;
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileDataImpl')
	*/
	public static function		createFromStream($stream)
	{
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->inputStream = $stream;
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileDataImpl')
	*/
	public static function		createFromNameBytes($name, $bytes)
	{
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->name = $name;
		$fileData->inputStream = \net\dryuf\io\IoUtil::openMemoryStream($bytes);
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileDataImpl')
	*/
	public static function		createFromBytes($bytes)
	{
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->inputStream = \net\dryuf\io\IoUtil::openMemoryStream($bytes);
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			close()
	{
		try {
			if (!is_null($this->inputStream))
				fclose($this->inputStream);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$name;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getName()
	{
		return $this->name;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setName($name_)
	{
		$this->name = $name_;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$size = -1;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getSize()
	{
		return $this->size;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSize($size_)
	{
		$this->size = $size_;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$modifiedTime = -1;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getModifiedTime()
	{
		return $this->modifiedTime;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setModifiedTime($modifiedTime_)
	{
		$this->modifiedTime = $modifiedTime_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$contentType;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContentType()
	{
		return $this->contentType;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setContentType($contentType_)
	{
		$this->contentType = $contentType_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	protected			$inputStream;

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			getInputStream()
	{
		return $this->inputStream;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setInputStream($inputStream_)
	{
		$this->inputStream = $inputStream_;
	}
};


?>
