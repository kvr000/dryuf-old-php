<?php

namespace net\dryuf\srvui;


class DummyRequest extends \net\dryuf\srvui\AbstractRequest
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->session = new \net\dryuf\srvui\DummySession();
		$this->response = new \net\dryuf\srvui\DummyResponse();
		$this->params = new \net\dryuf\util\php\StringNativeHashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getUri()
	{
		return $this->path.(!(($this->queryString) == null) ? "?".$this->queryString : "");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getParam($param)
	{
		return $this->params->get($param);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getParamDefault($param, $defaultValue)
	{
		$value = $this->getParam($param);
		return is_null($value) ? $defaultValue : $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getHeader($header)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getDateHeader($header)
	{
		return -1;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getLongHeader($header)
	{
		return -1;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getServletContext()
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getFile($param)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			resetData()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	public function			getSession()
	{
		return $this->session;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	public function			forceSession()
	{
		return $this->session;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			invalidateSession()
	{
		$this->session->invalidate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	public function			getResponse()
	{
		return $this->response;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addParam($name, $value)
	{
		$this->params->put($name, $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addParams($added)
	{
		foreach ($added->entrySet() as $x) {
			$this->params->put($x->getKey(), $x->getValue());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCookie($name)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRemoteHost()
	{
		return "NA";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContextPath()
	{
		return "";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$path = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPath()
	{
		return $this->path;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPath($path_)
	{
		$this->path = $path_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$queryString = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getQueryString()
	{
		return $this->queryString;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setQueryString($queryString_)
	{
		$this->queryString = $queryString_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$method = "GET";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMethod()
	{
		return $this->method;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setMethod($method_)
	{
		$this->method = $method_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$requestContentType = "application/json";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRequestContentType()
	{
		return $this->requestContentType;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRequestContentType($requestContentType_)
	{
		$this->requestContentType = $requestContentType_;
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

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	protected			$session;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	protected			$response;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$params;
};


?>
