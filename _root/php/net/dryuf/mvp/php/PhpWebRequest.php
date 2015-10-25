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


class PhpWebRequest extends \net\dryuf\srvui\AbstractRequest
{
	function			__construct()
	{
		$this->get_params = $_GET;
	}

	function			getResponse()
	{
		if (is_null($this->response))
			$this->response = new \net\dryuf\mvp\php\PhpWebResponse($this);
		return $this->response;
	}

	function			getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getContextPath()
	{
		return "";
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getRequestContentType()
	{
		$ct = $_SERVER['CONTENT_TYPE'];
		if (($p = strpos($ct, ";")) !== false)
			$ct = substr($ct, 0, $p);
		return $ct;
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getParam($param)
	{
		global $_POST;

		if (isset($this->get_params[$param]))
			return $this->get_params[$param];
		elseif (isset($_POST[$param]))
			return $_POST[$param];
		else
			return null;
	}

	function			getHeader($header)
	{
		global $_SERVER;

		$header = "HTTP_".strtoupper(str_replace("-", "_", $header));
		return isset($_SERVER[$header]) ? $_SERVER[$header] : null;
	}

	function			getDateHeader($header)
	{
		if (is_null($value = $this->getHeader($header)))
			return -1;
		$tm = strtotime($value)*1000;
		return $tm ? $tm : -1;
	}

	function			getLongHeader($header)
	{
		if (is_null($value = $this->getHeader($header)))
			return -1;
		return intval($value);
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getCookie($name)
	{
		global $_COOKIE;
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
	}

	/**
	@\net\dryuf\core\Type(type = "java.io.InputStream")
	*/
	function			getInputStream()
	{
		return fopen("php://input", "r");
	}

	/**
	@\net\dryuf\core\Type(type = "java.io.OutputStream")
	*/
	function			getOutputStream()
	{
		return fopen("php://outpu", "w");
	}

	/**
	@\net\dryuf\core\Type(type = "java.io.PrintWriter")
	*/
	function			getWriter()
	{
		return fopen("php://outpu", "w");
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getUri()
	{
		return $_SERVER['REQUEST_URI'];
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getPath()
	{
		return ($p = strpos($_SERVER['REQUEST_URI'], '?')) === false ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 0, $p);
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.String")
	*/
	function			getQueryString()
	{
		return $_SERVER['QUERY_STRING'];
	}

	/**
	@\net\dryuf\core\Type(type = "java.lang.Object")
	*/
	function			getServletContext()
	{
		throw new \RuntimeException("unsupported");
	}

	/**
	@\net\dryuf\core\Type(type = "net.dryuf.io.FileData")
	*/
	function			getFile($param)
	{
		global $_FILES;

		if (!isset($_FILES[$param]))
			return null;
		$filePhp = $_FILES[$param];

		if (!empty($filePhp['error']))
			throw new \net\dryuf\core\RuntimeException("error uploading file $param: $filePhp[error]");

		$fileData = \net\dryuf\io\FileDataImpl::createFromFilename($filePhp['tmp_name']);
		$fileData->setContentType($filePhp['type']);

		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	function			resetData()
	{
		$this->get_params = array();
	}

	/**
	@\net\dryuf\core\Type(type = "net.dryuf.srvui.Session")
	*/
	function			getSession()
	{
		if ($this->session == null) {
			if (!session_id())
				session_start();
			if (session_id())
				$this->session = new \net\dryuf\mvp\php\PhpWebSession();
		}
		return $this->session;
	}

	/**
	@\net\dryuf\core\Type(type = "net.dryuf.srvui.Session")
	*/
	function			forceSession()
	{
		if (!session_id())
			session_start();
		return $this->getSession();
	}

	function			invalidateSession()
	{
		$session = $this->getSession();
		if (!is_null($session))
			$session->invalidate();
		$this->session = null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRemoteHost()
	{
		return isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : $_SERVER['REMOTE_ADDR'];
	}

	protected			$response;

	protected			$session;

	protected			$get_params;
};


?>
