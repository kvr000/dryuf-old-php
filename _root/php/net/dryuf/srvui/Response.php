<?php

namespace net\dryuf\srvui;


interface Response
{
	/**
	@\net\dryuf\core\Type(type = 'java\io\OutputStream')
	*/
	function			getOutputStream();

	/**
	@\net\dryuf\core\Type(type = 'java\io\PrintWriter')
	*/
	function			getWriter();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			getCurrentStatus();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			sendHeader($header, $value);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			redirect($uri);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setContentType($contentType);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			sendError($code, $msg);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			sendStatus($code, $msg);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setHeader($header, $content);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setLongHeader($header, $value);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setDateHeader($header, $value);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setCookie($name, $value, $maxAge);
};


?>
