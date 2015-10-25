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


class Exception extends \Exception
{
	public function			__construct($message, $cause = null)
	{
		if (is_null($cause) && $message instanceof \Exception)
			$message = strval($cause = $message);
		parent::__construct($message, 0, $cause);
	}

	public function			getCause()
	{
		return $this->getPrevious();
	}

	public function			toString()
	{
		return $this->getMessage();
	}

	public function			__toString()
	{
		return $this->toString();
	}

	static function			formatReport($ex, $verbosity)
	{
		switch ($verbosity) {
		case 3:
			$trace = "";
			if (!is_null($ex->getFile()) && !is_null($ex->getLine())) {
				$trace .= "#_ {$ex->getFile()}:{$ex->getLine()}: throw\n";
			}
			$trace .= $ex->getTraceAsString();
			return $ex->getMessage()."\n".$trace."\n".self::formatCause($ex, $verbosity);

		case 2:
			$i = 0;
			$trace = "";
			if (!is_null($ex->getFile()) && !is_null($ex->getLine())) {
				$trace .= "#$i {$ex->getFile()}:{$ex->getLine()}: throw\n";
				$i++;
			}
			foreach ($ex->getTrace() as $frame) {
				$trace .= "#$i ".(isset($frame['file'])?"$frame[file]:$frame[line]":"{internal}").": ".(isset($frame['class'])?$frame['class'].$frame['type']:"")."$frame[function](...)\n";
				$i++;
			}
			return $ex->getMessage()."\n".$trace."\n".self::formatCause($ex, $verbosity);

		case 1:
			return $ex->getMessage();

		case 0:
			return "";
		}
	}

	public static function		formatCause($ex, $verbosity)
	{
		$previous = $ex->getPrevious();
		if (!$previous)
			return "";
		return "\nCaused by: ".self::formatReport($previous, $verbosity);
	}
};


?>
