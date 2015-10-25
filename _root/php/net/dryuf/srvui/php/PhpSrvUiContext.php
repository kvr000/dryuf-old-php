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

namespace net\dryuf\srvui\php;


class PhpSrvUiContext implements \net\dryuf\core\UiContext
{
	function			__construct($callerContext)
	{
		global $dr_started_time;

		$this->callerContext = $callerContext;

		$this->appContainer = $callerContext->getAppContainer();

		$this->workRoot = $callerContext->getWorkRoot();
		$this->etcPath = $this->workRoot."etc/";

		$this->setErrorLog(new \net\dryuf\logging\DummyLogger());
		$this->localizePath = $this->workRoot."localize";

		$this->dataCache = array();
		$this->localizeLog = new \net\dryuf\logging\DummyLogger();
		$this->errorLog = new \net\dryuf\logging\DummyLogger();

		$this->started_time = isset($dr_started_time) ? $dr_started_time : microtime(true);
		$this->pending_msgs = array();

		$this->setLocalizeContextPath($callerContext->getConfigValue("app.contextDomain", ""));
	}

	function			checkTimezone($tzname)
	{
		if (!is_null($tzname)) {
			try {
				$tzdb = \net\dryuf\keydb\DbaKeyValueDb::open($this->etcPath."timezone_map", "db4");
				$tzname = $tzdb->findOrDefault($tzname, $tzname);
				date_default_timezone_set($tzname);
			}
			catch (\net\dryuf\core\Exception $ex) {
				return false;
			}
		}
		return true;
	}

	function			getPendingMsgs()
	{
		$messages = array();
		foreach ($this->pending_msgs as $msg) {
			if (!preg_match('/^([EI]):(.*)$/', $msg, $regs))
				throw new \net\dryuf\core\Exception("invalid format of pending message: ".\net\dryuf\core\Dryuf::safeString($msg));
			array_push($messages, array("level" => $regs[1], 'msg' => $regs[2]));
		}
		return $messages;
	}

	function			putMessage($msg_type, $message)
	{
		array_push($this->pending_msgs, "$msg_type:$message");
	}

	function			putMessageLocalized($msg_type, $classname, $message)
	{
		array_push($this->pending_msgs, "$msg_type:".$this->localize($classname, $message));
	}

	function			getCallerContext()
	{
		return $this->callerContext;
	}

	function			setCallerContext($callerContext)
	{
		$this->callerContext = $callerContext;
	}

	function			logError($id, $text)
	{
		$this->errorLog->logError("$id: $text\n");
	}

	function			setErrorLog($log)
	{
		$this->errorLog = $log;
	}

	function			checkLanguage($language)
	{
		if (!preg_match('/^(\w{1,10})$/', $language))
			return false;
		if (is_null($this->appContainer->getConfigValue("localize.locale.$language", null)))
			return false;
		$this->setLanguage($language);
		return true;
	}

	function			getDefaultLanguage()
	{
		return $this->defaultLanguage;
	}

	function			getLanguage()
	{
		return $this->language;
	}

	function			setLanguage($language)
	{
		if (!preg_match('/^(\w{1,10})$/', $language))
			throw new \RuntimeException("invalid language: ".$language);
		if (is_null($locale = $this->appContainer->getConfigValue("localize.locale.$language", null)))
			throw new \RuntimeException("invalid language: ".$language);
		setlocale(LC_ALL, $locale);
		$this->language = $language;
		$this->localizeLog = new \net\dryuf\logging\FileLogger($this->workRoot."log/localize-$this->language.log");

		$localizeClazz = $this->appContainer->getConfigValue("localize.clazz", 'net\dryuf\keydb\DbaKeyValueDb');
		try {
			$this->localizer = $localizeClazz::open("$this->localizePath/$this->language/_dict");
		}
		catch (\net\dryuf\core\Exception $ex) {
			$this->localizeLog->logfError("open db %s failed: %s", "$this->localizePath/$this->language/_messages.localize", $ex->__toString());
			try {
				$this->localizer = $localizeClazz::open("$this->localizePath/$this->defaultLanguage/_messages.localize");
			}
			catch (\net\dryuf\core\Exception $ex) {
				$this->localizer = new \net\dryuf\keydb\DummyKeyValueDb();
			}
		}
	}

	function			setLanguageSys()
	{
		$this->setLanguage(trim(\net\dryuf\io\FileUtil::getCommentedFileContent($this->etcPath."sys_lang")));
	}

	function			setDefaultLanguage($defaultLanguage)
	{
		$this->defaultLanguage = $defaultLanguage;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			listLanguages()
	{
		$languages = $this->callerContext->getConfigValue("localize.languages", null);
		if (is_null($languages))
			throw new \net\dryuf\core\RuntimeException("localize.languages not set");
		return $languages;
	}

	function			getLocalizePath()
	{
		return $this->localizePath;
	}

	function			getLocalizeContextPath()
	{
		return $this->localizeContextPath;
	}

	function			setLocalizeContextPath($path)
	{
		$this->localizeContextPath = $path;
		$this->setDefaultLanguage($this->appContainer->getConfigValue("localize.defaultLanguage"));
		$this->setLanguage($this->getDefaultLanguage());
	}

	function			openContextFile($path, $file)
	{
		try {
			return \net\dryuf\io\FileUtil::openFileRead("$path$this->localizeContextPath$file");
		}
		catch (\net\dryuf\core\Exception $ex) {
			return \net\dryuf\io\FileUtil::openFileRead("$path$file");
		}
	}

	function			localize($classname, $text)
	{
		if (is_null($text))
			return null;
		if (!isset($this->localizeClassMapping[$classname]))
			$this->localizeClassMapping[$classname] = preg_replace('/(\\\\|::|\.)/', '.', $classname);
		$classname = $this->localizeClassMapping[$classname];
		if ($this->localizeDebug > 1)
			return "^$classname^$text^";
		if (is_null($t = $this->localizer->findOrDefault("$classname^$text", null))) {
			$this->localizeLog->logfError("translate: %s^%s", $classname, $text);
			$t = $this->localizeDebug ? "^$classname^$text^" : $text;
		}
		return $t;
	}

	function			getClassLocalization($classname)
	{
		$classname = $fname = preg_replace('/(::|\.|\\\\)/', '.', $classname);
		$localizeClazz = \net\dryuf\core\Dryuf::getConfigDefault("localize.clazz", 'net\dryuf\keydb\DbaKeyValueDb');
		try {
			$clocalizer = $localizeClazz::open("$this->localizePath/$this->language/_cls/$fname.cls");
		}
		catch (\net\dryuf\core\Exception $ex) {
			try {
				$clocalizer = $localizeClazz::open("$this->localizePath/$this->defaultLanguage/_cls/$fname.cls");
			}
			catch (\net\dryuf\core\Exception $ex2) {
				return new \net\dryuf\util\php\NativeHashMap();
			}
		}
		return $clocalizer->listPrefixedStrip("$classname^");
	}

	function			localizeArgs($classname, $text, $args)
	{
		$content = $this->localize($classname, $text);
		for ($p = 0; ($n = strpos($content, "{", $p)) !== false; ) {
			if (($q = strpos($content, "'", $p)) == $n-1) {
				$p = $q+2;
			}
			elseif (preg_match('/^(\d+)\}(.*)$/s', substr($content, $n+1), $match)) {
				$arg = $args[intval($match[1])];
				$content = substr($content, 0, $n).$arg.$match[2];
				$p = $n+strlen($arg);
			}
			else {
				throw new \net\dryuf\core\Exception("invalid translated message, cannot parse the argument number: ".$content);
			}
		}
		return $content;
	}

	function			localizeArgsEscape($escaper, $classname, $text, $args)
	{
		$content = $this->localize($classname, $text);
		for ($p = 0; ($n = strpos($content, "{", $p)) !== false; ) {
			if (($q = strpos($content, "'", $p)) == $n-1) {
				$p = $q+2;
			}
			elseif (preg_match('/^(\d+)\}(.*)/', substr($content, $n+1), $match)) {
				$arg = $escaper($args[intval($match[1])]);
				$content = substr($content, 0, $n).$arg.$match[2];
				$p = $n+strlen($arg);
			}
			else {
				throw new \net\dryuf\core\Exception("invalid translated message, cannot parse the argument number: ".$content);
			}
		}
		return $content;
	}

	function			readLocalizedFile($file)
	{
		try {
			$fd = \net\dryuf\io\FileUtil::openFileRead("$this->localizePath/$this->language/$this->localizeContextPath$file");
		}
		catch (\net\dryuf\core\Exception $ex) {
			$this->localizeLog->logfError("process: $this->localizePath/$this->language/$this->localizeContextPath$file");
			$fd = \net\dryuf\io\FileUtil::openFileRead("{$this->localizePath}/{$this->defaultLanguage}/$this->localizeContextPath$file");
		}
		return stream_get_contents($fd);
	}

	function			matchText($regexp, $text)
	{
		return \net\dryuf\srvui\RegExp::matchText($regexp, $text);
	}

	function			getLocalizeDebug()
	{
		return $this->localizeDebug;
	}

	function			setLocalizeDebug($level)
	{
		$this->localizeDebug = $level;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			getTiming()
	{
		return $this->timing;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTiming($timing_)
	{
		$this->timing = $timing_;
	}

	public				$appContainer;

	public				$workRoot;
	public				$etcPath;

	public				$localizeDebug = 0;
	public				$timing = false;
	public				$localizer;
	public				$localizeLog;
	public				$localizePath;
	public				$localizeContextPath = "";
	public				$pending_msgs;
	public				$language;
	public				$defaultLanguage;
	public				$errorLog;
	public				$dataCache;

	public				$localizeClassMapping = array();

	public				$started_time;
};


?>
