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

namespace net\dryuf\core;


#global $dr_ns_test;
#$dr_ns_test =<<<EOS
#\n\C()
#EOS;


class Dryuf
{
	public static function		lastErrorDesc()
	{
		if (is_null($err = error_get_last()))
			return null;
		return $err['message'];
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		convertClassname($name)
	{
		#global $dr_ns_test;
		#if ($dr_ns_test == "n_C()")
		#	$name = preg_replace('/::/', '_', $name);
		#else
		#	$name = preg_replace('/(::|\.)/', '\\', $name);
		#return $name;
		return isset(self::$convertedClasses[$name]) ? self::$convertedClasses[$name] : (self::$convertedClasses[$name] = preg_replace('/(::|\.)/', '\\', $name));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		dotClassname($name)
	{
		return preg_replace('/(::|\\\\)/', '.', $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		pathClassname($name)
	{
		return preg_replace('/(::|\\\\|\.)/', '/', $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		dashClassname($name)
	{
		return preg_replace('/(::|\\\\|\.)/', '-', $name);
	}

	public static function		formatClassname($php_classname)
	{
		return preg_replace('/\\\\/', '::', $php_classname);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		assertNotNull($value, $message = null)
	{
		if (is_null($value))
			throw new \net\dryuf\core\NullPointerException(is_null($message) ? "Value cannot be null" : $message);
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public static function		loadClass($name)
	{
		return self::convertClassname($name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg0($clazz)
	{
		$convname = self::loadClass($clazz);
		return new $convname();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg1($clazz, $arg)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg2($clazz, $arg0, $arg1)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg0, $arg1);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg3($clazz, $arg0, $arg1, $arg2)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg0, $arg1, $arg2);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg4($clazz, $arg0, $arg1, $arg2, $arg3)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg0, $arg1, $arg2, $arg3);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg5($clazz, $arg0, $arg1, $arg2, $arg3, $arg4)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg0, $arg1, $arg2, $arg3, $arg4);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg6($clazz, $arg0, $arg1, $arg2, $arg3, $arg4, $arg5)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg0, $arg1, $arg2, $arg3, $arg4, $arg5);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		createClassArg7($clazz, $arg0, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6)
	{
		$convname = self::loadClass($clazz);
		return new $convname($arg0, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6);
	}

	public static function		callClassStatic($classname, $function, $args = null)
	{
		$convname = self::loadClass($classname);
		return is_null($args) ? call_user_func(array($convname, $function)) : call_user_func_array(array($convname, $function), $args);
	}

	public static function		invokeMethodString0($object, $methodName)
	{
		return $object->$methodName();
	}

	public static function		getFieldValueNamed($object, $fieldName)
	{
		$classRef = new \ReflectionClass(get_class($object));
		$propertyRef = $classRef->getProperty($fieldName);
		$propertyRef->setAccessible(true);
		return $propertyRef->getValue($object);
	}

	public function			translateException($ex)
	{
		if ($ex instanceof \RuntimeException || $ex instanceof \net\dryuf\core\RuntimeException) {
			return $ex;
		}
		else {
			return new RuntimeException($ex);
		}
	}

	public static function		isCli()
	{
		return php_sapi_name() === "cli";
	}

	public static function		installDryufEnv()
	{
		self::installThrowErrorHandler();
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		self::installClassLoader();
	}

	public static function		installThrowErrorHandler()
	{
		set_error_handler(array(self::convertClassname("net.dryuf.core.Dryuf"), "throwErrorHandler"));
	}

	public static function		shutdownErrorHandler()
	{
		$err = error_get_last();
		if (!is_null($err) && ($err['type']&(E_ERROR|E_COMPILE_ERROR|E_PARSE|E_CORE_ERROR)))
			self::exceptionHandler(new \net\dryuf\core\PhpException(-1, $err['message'], $err['file'], $err['line'], array()));
	}

	public static function		throwErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		if (error_reporting() == 0)
			return;
		throw new \net\dryuf\core\PhpException($errno, $errstr, $errfile, $errline, $errcontext);
	}

	public static function		installExceptionHandler()
	{
		set_exception_handler(array(self::convertClassname("net.dryuf.core.Dryuf"), "exceptionHandler"));
		register_shutdown_function(array(self::convertClassname("net.dryuf.core.Dryuf"), "shutdownErrorHandler"));
	}

	public static function		exceptionHandler($ex)
	{
		$report = self::getExceptionReport($ex);
		if (self::isCli()) {
			fputs(STDERR, $report);
		}
		else {
			if (!headers_sent()) {
				header($_SERVER['SERVER_PROTOCOL']." 500 Internal server error");
				header("content-type: text/html; charset=UTF-8");
			}
			echo "<p><code><pre>\n".htmlspecialchars($report)."</pre></code></p>\n";
		}
		exit(127);
	}

	public static function		getExceptionReport($ex)
	{
		return \net\dryuf\core\Exception::formatReport($ex, self::$printUnhandled);
	}

	public static function		installClassLoader()
	{
		spl_autoload_register(array(self::convertClassname("net.dryuf.core.Dryuf"), "classLoader"));
	}

	public static function		classLoader($classname)
	{
		$errors = "";
		$classfile = preg_replace('/\\\\/', '/', $classname);
		if (strpos($classfile, '/') === 0)
			$classfile = substr($classfile, 1);
		for (;;) {
			try {
				if (include_once "$classfile.php") {
					if (!class_exists($classname) && !interface_exists($classname)) {
						throw new \net\dryuf\core\ClassNotFoundException($classname, "class file $classfile.php loaded but the class is still undefined");
					}
					return;
				}
			}
			catch (\Exception $ex) {
				$errors .= $ex->__toString()."\n";
			}
			if (($p = strpos($classfile, "_")) === false) {
				throw new \net\dryuf\core\ClassNotFoundException($classname, $errors);
			}
			$classfile = substr($classfile, 0, $p)."/".substr($classfile, $p+1);
		}
	}

	public static function		multiply1000($value)
	{
		return !is_null($value) ? 1000*$value : null;
	}

	public static function		nullFalse($value)
	{
		return $value === false ? null : $value;
	}

	public static function		safeString($str)
	{
		return preg_replace('/([\x00-\x31])/e', 'sprintf("\\\\\\x%02x", ord(\'\\1\'))', $str);
	}

	public static function		lineDump($obj)
	{
		return preg_replace('/\n\s*/s', " ", var_export($obj, 1));
	}

	public static function		dumpContent($var, $level)
	{
		if ($level < 0)
			return "- MAX LEVEL -";
		if (is_array($var)) {
			$content = "array(\n";
			foreach ($var as $k => $v) {
				$content .= "$k => ".self::dumpContent($v, $level-1).",\n";
			}
			$content .= ")";
		}
		else {
			$content = var_export($var, 1);
		}
		return $content;
	}

	public static function		getClass($obj)
	{
		switch (gettype($obj)) {
		case "boolean":
			return 'boolean';
		case "integer":
			return 'integer';
		case "float":
			return 'float';
		case "double":
			return 'double';
		case "string":
			return 'string';
		case "array":
			return 'array';
		case "resource":
			return 'resource';
		case "object":
			return get_class($obj);
		default:
			return 'unknown';
		}
	}

	public static function		toBool($value)
	{
		return !empty($value);
	}

	public static function		convertBool($value)
	{
		return !empty($value);
	}

	public static function		parseInt($text, $radix = null)
	{
		try {
			if (!is_null($radix))
				$text = base_convert($text, $radix, 10);
			if (!preg_match('/^[-+]?(0x[0-9a-fA-F]+|\d+)$/', $text))
				throw new \net\dryuf\core\NumberFormatException("Invalid format for int: ".$text);
			if (($r = intval($text)) === false)
				throw new \net\dryuf\core\NumberFormatException("Invalid format for int: ".$text);
			return $r;
		}
		catch (\Exception $ex) {
			throw new \net\dryuf\core\NumberFormatException("Invalid format for int: ".$text);
		}
	}

	public static function		parseFloat($text)
	{
		return self::parseDouble($text);
	}

	public static function		parseDouble($text)
	{
		if (!is_numeric($text))
			throw new \net\dryuf\core\NumberFormatException("Invalid format for float: ".$text);
		return doubleval($text);
	}

	public static function		getInternalObjectHash($obj)
	{
		return hexdec(substr(spl_object_hash($obj), -8, 0));
	}

	public static function		map($processor, $list)
	{
		$out = array();
		for ($i = 0; $i < count($list); $i++)
			array_push($out, $processor($list[$i], $i));
		return $out;
	}

	public static function		allocArray($values, $dimension0 /* ...$dimensions */)
	{
		$args = func_get_args();
		$values = array_shift($args);
		$dimension0 = array_shift($args);
		if (count($args) == 0) {
			return $dimension0 == 0 ? array() : array_fill(0, $dimension0, $values);
		}
		else {
			array_unshift($args, $values);
			$result = array();
			while ($dimension0--)
				array_push($result, call_user_func_array(array('net\dryuf\core\Dryuf', 'allocArray'), $args));
			return $result;
		}
	}

	public static function		getArrayKey($arr, $key, $default_val)
	{
		return array_key_exists($key, $arr) ? $arr[$key] : $default_val;
	}

	public static function		defvalue($value, $defvalue)
	{
		return is_null($value) ? $defvalue : $value;
	}

	public static function		getConfig($var_name)
	{
		return isset(self::$config[$var_name]) ? self::$config[$var_name] : null;
	}

	public static function		getConfigDefault($var_name, $default)
	{
		return isset(self::$config[$var_name]) ? self::$config[$var_name] : $default;
	}

	/**
	 * Wrapper functions that performs hash code computation, no matter whether argument is scalar or object.
	 *
	 * @param $arg
	 * 	value to compute hash code from
	 *
	 * @return
	 * 	{@code $arg} hash code
	 */
	public static function		hashCodeObject($arg)
	{
		return is_string($arg) ? ord($arg) : (is_int($arg) ? $arg : (is_bool($arg) ? intval($arg) : (is_float($arg) ? intval($arg) : (is_array($arg) ? count($arg) : $arg->hashCode()))));
	}

	/**
	 * Compare two values for equality, no matter whether arguments are scalar or objects.
	 *
	 * @param $o0
	 * 	first value to compare
	 * @param $o1
	 * 	first value to compare
	 *
	 * @return false
	 * 	if the arguments are different
	 * @return true
	 * 	if the arguments are equal
	 */
	public static function		equalObjects($o0, $o1)
	{
		return is_object($o0) ? $o0->equals($o1) : $o0 === $o1;
	}

	/**
	 * Compare two values, no matter whether arguments are scalar or objects.
	 *
	 * @param $o0
	 * 	first value to compare
	 * @param $o1
	 * 	first value to compare
	 *
	 * @return < 0
	 * 	if the first object is smaller
	 * @return = 0
	 * 	if objects are equal
	 * @return > 0
	 * 	if the first object is smaller
	 */
	public static function		compareObjects($o0, $o1)
	{
		return is_object($o0) ? $o0->compareTo($o1) : $o0 >= $o1 ? $o0 > $o1 ? 1 : 0 : -1;
	}

	/**
	 * Compare two values, being safe of nulls, no matter whether arguments are scalar or objects.
	 *
	 * Nulls are treated as lowest values.
	 *
	 * @param $o0
	 * 	first value to compare
	 * @param $o1
	 * 	first value to compare
	 *
	 * @return < 0
	 * 	if the first object is smaller
	 * @return = 0
	 * 	if objects are equal
	 * @return > 0
	 * 	if the first object is smaller
	 */
	public static function		compareObjectsSafe($o0, $o1)
	{
		return is_null($o0) ? is_null($o1) ? 0 : -1 : is_null($o1) ? 1 : is_object($o0) ? $o0->compareTo($o1) : $o0 >= $o1 ? $o0 > $o1 ? 1 : 0 : -1;
	}

	public static function		loadCachedFile($filename)
	{
		if (is_null(self::$cachePath))
			return null;
		try {
			if (($content = file_get_contents(self::$cachePath."/".$filename)) === false)
				$content = null;
		}
		catch (\net\dryuf\core\PhpException $ex) {
			$content = null;
		}
		return $content;
	}

	public static function		saveCachedFile($filename, $content)
	{
		if (is_null(self::$cachePath))
			return null;
		try {
			if (!file_put_contents(self::$cachePath."/".$filename, $content))
				throw new \net\dryuf\core\PhpException("failed to save");
		}
		catch (\net\dryuf\core\PhpException $ex) {
			\net\dryuf\io\DirUtil::mkpath(self::$cachePath.dirname("/".$filename));
			if (!file_put_contents(self::$cachePath."/".$filename, $content))
				throw new \net\dryuf\core\PhpException("failed to save");
		}
	}

	public static function		getCached($owner, $driver, $key)
	{
		return self::$dataCache->get($owner, $driver, $key);
	}

	public static function		putCached($owner, $driver, $key, $content)
	{
		self::$dataCache->put($owner, $driver, $key, $content);
	}

	public static function		getVmCached($owner, $driver, $key)
	{
		if (isset(self::$vmCache[$owner][$driver][$key]))
			return self::$vmCache[$owner][$driver][$key];
		return self::$vmCache[$owner][$driver][$key] = self::$dataCache->get($owner, $driver, $key);
	}

	public static function		putVmCached($owner, $driver, $key, $content)
	{
		self::$vmCache[$owner][$driver][$key] = $content;
		self::$dataCache->put($owner, $driver, $key, $content);
	}

	public static function		resetVmCache()
	{
		self::$vmCache = array();
	}

	/*
	 * Annotation processing functions, we keep them in the core support file.
	 */
	public static function		parseSourceString(&$docblock)
	{
		if (!preg_match('/^([\'"])(.*)$/s', $docblock, $match))
			throw new \net\dryuf\core\Exception("unexpected string value: $docblock");
		if ($match[1] == "\"") {
			$docblock = $match[2];
			if (!preg_match('/^(([^"\\\\]+|\\\\.)*)"(.*)$/s', $docblock, $match))
				throw new\net\dryuf\core\Exception("cannot find end of string: $docblock");
			$docblock = $match[3];
			$value = eval("return \"".$match[1]."\";");
			return $value;
		}
		else if ($match[1] == "'") {
			$docblock = $match[2];
			if (!preg_match('/^(([^\'\\\\]+|\\\\.)*)\'(.*)$/s', $docblock, $match))
				throw new\net\dryuf\core\Exception("cannot find end of string: $docblock");
			$docblock = $match[3];
			$value = eval("return '".$match[1]."';");
			return $value;
		}
		else {
			throw new \net\dryuf\core\Exception("unsupported string: $docblock");
		}
	}

	public static function		parseAnnotationValue(&$docblock)
	{
		if (!preg_match('/^\s*(((\{\s*(.*))|(@\\\\?((\w+[.\\\\])*(\w+))).*|(\d\w+|null|true|false)(\W+.*|)|(\\\\?\w+[.a-zA-Z_0-9:\\$\\\\]*)\s*([,\\)].*|)|(["\'].*)))$/s', $docblock, $match))
			throw new \net\dryuf\core\Exception("unexpected annotation value: $docblock");
		if (!empty($match[3])) {
			$docblock = $match[4];
			$value = array();
			while (substr($docblock, 0, 1) != "}") {
				array_push($value, self::parseAnnotationValue($docblock));
			}
			$docblock = substr($docblock, 1);
		}
		elseif (!empty($match[6])) {
			$value = self::parseOneAnnotation($docblock);
		}
		elseif (!empty($match[9])) {
			$value = eval("return ".$match[9].";");
			$docblock = $match[10];
		}
		elseif (!empty($match[11])) {
			$value = eval("return ".$match[11].";");
			$docblock = $match[12];
		}
		else {
			$value = self::parseSourceString($docblock);
		}
		if (!preg_match('/^\s*([,\\)}])\\s*(.*)$/s', $docblock, $match))
			throw new \net\dryuf\core\Exception("failed to find separator/end of annotation arguments: $docblock");
		$docblock = $match[1] != "," ? $match[1].$match[2] : $match[2];
		return $value;
	}

	public static function		parseAnnotationArgs(&$docblock)
	{
		$args = array();
		if (!preg_match('/^\(\s*((\S).*)$/s', $docblock, $match))
			throw new \net\dryuf\core\Exception("invalid annotation args start at $docblock");
		$docblock = $match[1];
		for (;;) {
			if (!preg_match('/^((\))|((\w+)\s*=))\s*(.*)$/s', $docblock, $match))
				throw new \net\dryuf\core\Exception("invalid format for annotation param: $docblock");
			$docblock = $match[5];
			if (!empty($match[2])) {
				break;
			}
			else {
				$args[$match[4]] = self::parseAnnotationValue($docblock);
			}
		}
		return $args;
	}

	public static function		parseOneAnnotation(&$docblock)
	{
		if (preg_match('/^\s*@(\\\\?([a-zA-Z_]\w*[.\\\\])*([A-Z]\w*))\s*((\().*|.*)$/s', $docblock, $match)) {
			$clazz = self::convertClassname($match[1]);
			$docblock = $match[4];
			if (!empty($match[5])) {
				$args = self::parseAnnotationArgs($docblock);
			}
			else {
				$args = array();
			}
			return new $clazz($args);
		}
		return null;
	}

	public static function		parseAnnotations($docblock)
	{
		$annotations = array();
		if (empty($docblock))
			return $annotations;
		$docblock = preg_replace(',\*/$,s', '', $docblock);
		$docblock = preg_replace(',\n\s*\*\s*,s', '', $docblock);
		$docblock = preg_replace(',^/\*\*\s*,s', '', $docblock);
		if (!preg_match(',^(|.*?\s)(@.*)$,s', $docblock, $match))
			return $annotations;
		$docblock = $match[2];
		$docblock = preg_replace(',^\s*/.*?(@[.\\\\]?([a-z]\w*[.\\\\])*([A-Z]\w*).*),s', '$1', $docblock);

		for (;;) {
			if (is_null($annotation = self::parseOneAnnotation($docblock))) {
				if (trim($docblock))
					throw new \net\dryuf\core\Exception("unexpected annotation content: $docblock");
				break;
			}
			$annotations[get_class($annotation)] = $annotation;
		}
		return $annotations;
	}

	// testing/benchmarking purposes only
	public static function		resetAnnotations()
	{
		self::$annotations = array();
	}

	public static function		loadClassAnnotations($clazz)
	{
		$clazzName = self::convertClassname($clazz);
		if (!isset(self::$annotations[$clazzName])) {
			$clazz = self::dotClassname($clazz);
			try {
				if ((self::$annotations[$clazzName] = self::getVmCached(__CLASS__, "phpannotations", $clazz)))
					return self::$annotations[$clazzName];
				self::$annotations[$clazzName] = null;
			}
			catch (\Exception $ex) {
			}
			$clazzRef = new \ReflectionClass($clazzName);
			$parentRef = $clazzRef->getParentClass();
			if ($parentRef) {
				$parentAll = self::loadClassAnnotations($parentRef->getName());
				$classed = $parentAll[0];
				$properties = $parentAll[1];
				$propertiesFilter = $parentAll[2];
				$methods = $parentAll[3];
				$methodsFilter = $parentAll[4];
			}
			else {
				$classed = array();
				$methods = array();
				$methodsFilter = array();
				$properties = array();
				$propertiesFilter = array();
			}
			foreach ($clazzRef->getMethods() as $methodRef) {
				$name = $methodRef->getName();
				try {
					$annos = self::parseAnnotations($methodRef->getDocComment());
				}
				catch (\net\dryuf\core\Exception $ex) {
					throw new \RuntimeException("failed to parse $clazz.$name: ".$ex->getMessage(), 0, $ex);
				}
				foreach ($annos as $annoName => $annoValue) {
					$methods[$name][$annoName] = $annoValue;
					$methodsFilter[$annoName][$methodRef->getName()] = $annoValue;
				}
				$methods[$name][''] = $name;
			}
			foreach ($clazzRef->getProperties() as $propertyRef) {
				$name = $propertyRef->getName();
				try {
					$annos = self::parseAnnotations($propertyRef->getDocComment());
				}
				catch (\net\dryuf\core\Exception $ex) {
					throw new \RuntimeException("failed to parse $clazz.$name: ".$ex->getMessage(), 0, $ex);
				}
				foreach ($annos as $annoName => $annoValue) {
					$properties[$name][$annoName] = $annoValue;
					$propertiesFilter[$annoName][$propertyRef->getName()] = $annoValue;
				}
				$properties[$name][''] = $name;
			}
			try {
				$classed = array_merge($classed, self::parseAnnotations($clazzRef->getDocComment()));
			}
			catch (\net\dryuf\core\Exception $ex) {
				throw new \RuntimeException("failed to parse $clazz.$name: ".$ex->getMessage(), 0, $ex);
			}
			$all = array(
				$classed,
				$properties,
				$propertiesFilter,
				$methods,
				$methodsFilter,
			);
			self::putVmCached(__CLASS__, "phpannotations", $clazz, $all);
			self::$annotations[$clazzName] = $all;
		}
		return self::$annotations[$clazzName];
	}

	public static function		getClassAnnotation($clazz, $annotation)
	{
		$annos = self::loadClassAnnotations($clazz);
		$annotation = self::convertClassname($annotation);
		return isset($annos[0][$annotation]) ? $annos[0][$annotation] : null;
	}

	public static function		getClassMandatoryAnnotation($clazz, $annotation)
	{
		$annos = self::loadClassAnnotations($clazz);
		$annotation = self::convertClassname($annotation);
		if (is_null($a = isset($annos[0][$annotation]) ? $annos[0][$annotation] : null)) {
			throw new \RuntimeException("annotation $annotation not found on class $clazz");
		}
		return $a;
	}

	public static function		getFieldAnnotation($clazz, $field, $annotation)
	{
		$annos = self::loadClassAnnotations($clazz);
		$annotation = self::convertClassname($annotation);
		return isset($annos[1][$field][$annotation]) ? $annos[1][$field][$annotation] : null;
	}

	public static function		getMethodAnnotation($clazz, $method, $annotation)
	{
		$annos = self::loadClassAnnotations($clazz);
		$annotation = self::convertClassname($annotation);
		return isset($annos[3][$method][$annotation]) ? $annos[3][$method][$annotation] : null;
	}

	/**
	 * Returns all fields having specified annotation.
	 *
	 * @param $clazz
	 * 	class name
	 * @param $annotation
	 * 	annotation class name
	 *
	 * @return array
	 * 	map of field name to annotation value
	 */
	public static function		listFieldsByAnnotation($clazz, $annotation)
	{
		$annos = self::loadClassAnnotations($clazz);
		$annotation = self::convertClassname($annotation);
		return isset($annos[2][$annotation]) ? $annos[2][$annotation] : array();
	}

	/**
	 * Returns all methods having specified annotation.
	 *
	 * @param $clazz
	 * 	class name
	 * @param $annotation
	 * 	annotation class name
	 *
	 * @return array
	 * 	map of method name to annotation value
	 */
	public static function		listMethodsByAnnotation($clazz, $annotation)
	{
		$annos = self::loadClassAnnotations($clazz);
		$annotation = self::convertClassname($annotation);
		return isset($annos[4][$annotation]) ? $annos[4][$annotation] : array();
	}

	/**
	 * Returns type of field as name of the class.
	 *
	 * @param clazz
	 * 	name of the class
	 * @param field
	 * 	name of the field
	 *
	 * @return
	 * 	class name of the field
	 *
	 * @note
	 * 	If the type of the field is generic based (i.e. List<String>), full identifier using sharp brackets syntax
	 * 	is returned.
	 */
	public static function		getFieldType($clazz, $field)
	{
		if (is_null($typeAnno = self::getFieldAnnotation($clazz, $field, 'net\dryuf\core\Type')))
			throw new \RuntimeException("No net.dryuf.core.Type annotation on $clazz.$field");
		return $typeAnno->type();
	}

	/**
	 * Returns the return type of method as name of the class.
	 *
	 * @param clazz
	 * 	name of the class
	 * @param method
	 * 	name of the method
	 *
	 * @return
	 * 	class name of return type of the method
	 *
	 * @note
	 * 	If the type is generic based (i.e. List<String>), full identifier using sharp brackets syntax is
	 * 	returned.
	 */
	public static function		getMethodReturnType($clazz, $method)
	{
		if (is_null($typeAnno = self::getMethodAnnotation($clazz, $method, 'net\dryuf\core\Type')))
			throw new \RuntimeException("No net.dryuf.core.Type annotation on $clazz.$method()");
		return $typeAnno->type();
	}

	/**
	 * Hash of loaded classes.
	 */
	protected static		$loadedClasses = array();

	/**
	 * Hash of converted classes.
	 */
	protected static		$convertedClasses = array();

	/**
	 * Hash of annotations (classname => annotations).
	 */
	protected static		$annotations = array();

	/**
	 * Indicator of what to print in case of unhandled exception:
	 * 	- 0: print only internal error message
	 * 	- 1: print exception message
	 * 	- 2: print message and stack trace
	 * 	- 3: print message and stack trace including function arguments (may contains sensitive data, development
	 * 	only)
	 * .
	 */
	public static			$printUnhandled = 0;

	/**
	 * Root path of working area.
	 */
	public static			$workRoot;

	/**
	 * Data cache handler.
	 */
	public static			$dataCache;

	/**
	 * VM internal cache (identifier => value).
	 */
	public static			$vmCache = array();

	/**
	 * Generic configuration values (name => value).
	 */
	public static			$config = array();

	/**
	 * Hash of beans (name => creator).
	 */
	public static			$beans = array();

	/**
	 * List of AOP processors (executed in order of presence).
	 */
	public static			$aops = array();
}


require_once "net/dryuf/core/Exception.php";
require_once "net/dryuf/core/PhpException.php";
require_once "net/dryuf/dryuf-compat.php";

?>
