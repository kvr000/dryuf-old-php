<?php

#
# Dryuf framework
#
# ----------------------------------------------------------------------------------
#
# Copyright (C) 2000-2015 Zbyněk Vyškovský
#
# ----------------------------------------------------------------------------------
#
# LICENSE:
#
# This file is part of Dryuf
#
# Dryuf is free software; you can redistribute it and/or modify it under the
# terms of the GNU Lesser General Public License as published by the Free
# Software Foundation; either version 3 of the License, or (at your option)
# any later version.
#
# Dryuf is distributed in the hope that it will be useful, but WITHOUT ANY
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
# FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for
# more details.
#
# You should have received a copy of the GNU Lesser General Public License
# along with Dryuf; if not, write to the Free Software Foundation, Inc., 51
# Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#
# @author	2000-2015 Zbyněk Vyškovský
# @link		mailto:kvr@matfyz.cz
# @link		http://kvr.matfyz.cz/software/java/dryuf/
# @link		http://github.com/dryuf/
# @license	http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License v3
#


namespace net\dryuf\mvp\php;


class PhpWebResponse implements \net\dryuf\srvui\Response
{
	function			__construct($request)
	{
		$this->get_params = $_GET;
	}

	/**
	@\net\dryuf\core\Type(type = "java.io.OutputStream")
	*/
	function			getOutputStream()
	{
		return fopen("php://output", "a");
	}

	/**
	@\net\dryuf\core\Type(type = "java.io.PrintWriter")
	*/
	function			getWriter()
	{
		return fopen("php://output", "a");
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.Object")
	*/
	function			getServletContext()
	{
		throw new \RuntimeException("unsupported");
	}

	function			getCurrentStatus()
	{
		return $this->statusCode;
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			sendHeader($header, $value)
	{
		header("$header: ".urlencode($value));
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			setContentType($mime)
	{
		header("content-type: $mime");
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			redirect($uri)
	{
		$this->statusCode = 302;
		header("location: ".$uri);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			sendError($code, $msg)
	{
		$this->statusCode = $code;
		header($_SERVER['SERVER_PROTOCOL']." $code ".urlencode($msg), true, $code);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			sendStatus($code, $msg)
	{
		$this->statusCode = $code;
		header($_SERVER['SERVER_PROTOCOL']." $code ".urlencode($msg), true, $code);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			setHeader($header, $value)
	{
		header("$header: ".$value);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			setLongHeader($header, $value)
	{
		header("$header: ".$value);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			setDateHeader($header, $value)
	{
		header("$header: ".gmdate("D, d M Y G:i:s T", $value/1000));
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			setCookie($name, $value, $maxAge)
	{
		setcookie($name, $value, time()+$maxAge);
	}

	protected			$statusCode;
};


?>
