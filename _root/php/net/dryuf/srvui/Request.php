<?php

namespace net\dryuf\srvui;


interface Request
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	function			getResponse();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getMethod();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getContextPath();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRequestContentType();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getParam($param);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getParamDefault($param, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getParamMandatory($param);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextual($param, $textual);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextualDefault($param, $textual, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextualMandatory($param, $textual);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getHeader($header);

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			getDateHeader($header);

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			getLongHeader($header);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getCookie($name);

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	function			getInputStream();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getUri();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getPath();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getQueryString();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getServletContext();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getFile($param);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	function			getSession();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	function			forceSession();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			invalidateSession();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRemoteHost();
};


?>
