<?php

namespace net\dryuf\srvui;


class DummyResponse extends \net\dryuf\core\Object implements \net\dryuf\srvui\Response
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->outputStream = \net\dryuf\io\IoUtil::openMemoryStream("");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\OutputStream')
	*/
	public function			getOutputStream()
	{
		return $this->outputStream;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\PrintWriter')
	*/
	public function			getWriter()
	{
		if (is_null($this->writer))
			$this->writer = new \java\io\PrintWriter($this->outputStream);
		return $this->writer;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getCurrentStatus()
	{
		return $this->statusCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			getOutputData()
	{
		return \net\dryuf\io\IoUtil::readMemoryStreamContent($this->outputStream);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setContentType($contentType)
	{
		$this->contentType = $contentType;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			sendHeader($header, $value)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			redirect($uri)
	{
		$this->redirected = $uri;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			sendError($code, $msg)
	{
		$this->statusCode = $code;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			sendStatus($code, $msg)
	{
		$this->statusCode = $code;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setHeader($header, $content)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLongHeader($header, $value)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDateHeader($header, $value)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCookie($name, $value, $maxAge)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\ByteArrayOutputStream')
	*/
	protected			$outputStream;

	/**
	@\net\dryuf\core\Type(type = 'java\io\PrintWriter')
	*/
	protected			$writer;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$statusCode = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$redirected = null;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRedirected()
	{
		return $this->redirected;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$contentType = null;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContentType()
	{
		return $this->contentType;
	}
};


?>
