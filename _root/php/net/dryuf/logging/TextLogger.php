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

namespace net\dryuf\logging;


abstract class TextLogger implements \net\dryuf\logging\Logger
{
	function			__construct()
	{
	}

	function			logDebug($msg)
	{
		$this->appendMessage("D", $msg);
	}

	function			logfDebug($format /*...*/)
	{
		$a = func_get_args();
		$this->logDebug(call_user_func_array("sprintf", $a));
	}

	function			dumpDebug($data, $msg)
	{
		$this->genericDump("D", $msg, $data);
	}

	function			dumpfDebug($data, $format)
	{
		$a = func_get_args();
		array_shift($a);
		$this->genericDump("D", call_user_func_array("sprintf", $a), $data);
	}

	function			logInfo($msg)
	{
		$this->appendMessage("I", $msg);
	}

	function			logfInfo($format /*...*/)
	{
		$a = func_get_args();
		$this->logInfo(call_user_func_array("sprintf", $a));
	}

	function			dumpInfo($data, $msg)
	{
		$this->genericDump("I", $msg, $data);
	}

	function			dumpfInfo($data, $format)
	{
		$a = func_get_args();
		array_shift($a);
		$this->genericDump("I", call_user_func_array("sprintf", $a), $data);
	}

	function			logWarning($msg)
	{
		$this->appendMessage("W", $msg);
	}

	function			logfWarning($format /*...*/)
	{
		$a = func_get_args();
		$this->logWarning(call_user_func_array("sprintf", $a));
	}

	function			dumpWarning($data, $msg)
	{
		$this->genericDump("W", $msg, $data);
	}

	function			dumpfWarning($data, $format)
	{
		$a = func_get_args();
		array_shift($a);
		$this->genericDump("W", call_user_func_array("sprintf", $a), $data);
	}

	function			logError($msg)
	{
		$this->appendMessage("E", $msg);
	}

	function			logfError($format /*...*/)
	{
		$a = func_get_args();
		$this->logError(call_user_func_array("sprintf", $a));
	}

	function			dumpError($data, $msg)
	{
		$this->genericDump("E", $msg, $data);
	}

	function			dumpfError($data, $format)
	{
		$a = func_get_args();
		array_shift($a);
		$this->genericDump("E", call_user_func_array("sprintf", $a), $data);
	}

	function			logFatal($msg)
	{
		$this->appendMessage("F", $msg);
	}

	function			logfFatal($format /*...*/)
	{
		$a = func_get_args();
		$this->logFatal(call_user_func_array("sprintf", $a));
	}

	function			genericDump($level, $msg, $data)
	{
		$this->appendMessage($level, $msg);
		$data_size = strlen($data);
		for ($pos = 0; $pos < $data_size; ) {
			$obuf = str_repeat(' ', 24+1+24+1+8+1+8+1);
			do {
				$code = ord(substr($data, $pos, 1));
				self::replaceInString($obuf, 3*($pos%16), sprintf("%02X", $code));
				self::replaceInString($obuf, 50+($pos%16), $code >= 32 && $code < 127 ? chr($code) : ".");
				++$pos;
			} while ($pos < $data_size && $pos%8 != 0);
			if ($pos < $data_size) {
				do {
					$code = ord(substr($data, $pos, 1));
					self::replaceInString($obuf, 1+3*($pos%16), sprintf("%02X", $code));
					self::replaceInString($obuf, 51+($pos%16), $code >= 32 && $code < 127 ? chr($code) : ".");
					++$pos;
				} while ($pos < $data_size && $pos%8 != 0);
			}
			$this->appendDump("D", $obuf);
		}
	}

	static function			replaceInString(&$str, $pos, $repl)
	{
		$str = substr($str, 0, $pos).$repl.substr($str, $pos+strlen($repl));
	}

	abstract function		appendMessage($level, $msg);
	abstract function		appendDump($level, $msg);
};


?>
