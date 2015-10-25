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

namespace net\dryuf\process;


class SignalManager
{
	static function			installSignalHandler($signo, $handler)
	{
		pcntl_signal($signo, function($signo) { \net\dryuf\sys\SignalProcessor::$lastSignalled = \net\dryuf\sys\SignalProcessor::$signalled[$signo] = $signo; });
		self::$handlers->put($signo, $handler);
	}

	static function			installIntHandler($handler)
	{
		installSignalHandler(SIGINT, $handler);
	}

	static function			installTermHandler($handler)
	{
		installSignalHandler(SIGTERM, $handler);
	}

	static function			installChldHandler($handler)
	{
		installSignalHandler(SIGCLD, $handler);
	}

	static function			installHupHandler($handler)
	{
		installSignalHandler(SIGHUP, $handler);
	}

	static function			gotSignal($signo)
	{
		if (self::$signalled[$signo]) {
			self::$signalled[$signo] = 0;
			return 1;
		}
		return 0;
	}

	static function			gotInt()
	{
		return self::gotSignal(SIGINT);
	}

	static function			gotTerm()
	{
		return self::gotSignal(SIGTERM);
	}

	static function			gotChld()
	{
		return self::gotSignal(SIGCLD);
	}

	static function			gotHup()
	{
		return self::gotSignal(SIGHUP);
	}

	static function			processSignals()
	{
		if (!self::$lastSignalled)
			return false;
		self::$lastSignalled = 0;
		for (self::$handlers->entrySet() as $entry) {
			$signo = $entry->getKey();
			if (self::gotSignal($signo)) {
				call_user_func($entry->getValue());
			}
		}
		return true;
	}

	static function			safeSleep($msec)
	{
		if (self::processSignals())
			return false;
		try {
			declare (ticks = 1)
				sleep($msec/1000);
			return true;
		}
		catch (\net\dryuf\core\PhpException $ex) {
			declare (ticks = 1) {
			}
			processSignals();
			return false;
		}
	}

	static function			safeSelect($read, $write, $exception, $msec)
	{
		if (self::processSignals())
			return false;
		try {
			declare (ticks = 1)
				$err = stream_select($read, $write, $exception, $msec/1000);
			return $err === false ? false : true;
		}
		catch (\net\dryuf\core\PhpException $ex) {
			// hope the exception is a result of EINTR
			declare (ticks = 1) {
			}
			processSignals();
			return false;
		}
	}

	static function			safeSingleReadSelect($stream, $msec)
	{
		if (self::processSignals())
			return false;
		$r = array($stream); $w = null; $e = null;
		try {
			declare (ticks = 1)
				$err = stream_select($r, $w, $e, $msec/1000);
			return $err === false ? 0 : in_array($stream, $r);
		}
		catch (\net\dryuf\core\PhpException $ex) {
			// hope the exception is a result of EINTR
			declare (ticks = 1) {
			}
			processSignals();
			return false;
		}
	}

	public static			$handlers = new \net\dryuf\util\LinkedHashMap();

	public static			$signalled = array_fill(0, 64);

	public static			$lastSignalled = 0;
};


?>
