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

namespace net\dryuf\tenv\reporter;


class TapReporter extends \net\dryuf\tenv\reporter\AbstractReporter
{
	function			__construct($presenter)
	{
		parent::__construct($presenter);
	}

	public function			reportAllStart($classCount, $totalCount)
	{
		$this->output("TAP version 13\n");
		$this->output("1..".$totalCount."\n");
	}

	public function			reportAllEnd($classCount, $classFailed, $totalCount, $totalFailed)
	{
	}

	public function			reportClassCreateFailure($testClass, $totalIndex, $ex)
	{
		$this->output("not ok ".($totalIndex+1)." - ".\net\dryuf\core\Dryuf::dotClassname($testClass) ." class instantiation failure : ".$this->reformatExceptionYaml(\net\dryuf\core\Exception::formatReport($ex, 2)));
	}

	public function			reportMethodStart($testObject, $method, $index, $totalIndex)
	{
	}

	public function			reportMethodEnd($testObject, $method, $index, $totalIndex, $error, $millitime)
	{
		if (is_null($error)) {
			$this->output("ok ".($totalIndex+1)." - ".\net\dryuf\core\Dryuf::dotClassname(get_class($testObject)).".".$method." time=".number_format($millitime/1000.0, 3, ".", "")."s\n");
		}
		else {
			$this->output("not ok ".($totalIndex+1)." - ".\net\dryuf\core\Dryuf::dotClassname(get_class($testObject)).".".$method." time=".number_format($millitime/1000.0, 3, ".", "")." : ".$this->reformatExceptionYaml($error));
		}
	}

	public function			reformatExceptionYaml($error)
	{
		if (($pos = strpos($error, "\n")) === false) {
			return $error;
		}
		$message = substr($error, 0, $pos);
		$stacktrace = substr($error, $pos+1);
		$stacktrace = preg_replace('/^(.*)$/m', "                \"$1\"", trim($stacktrace));
		return $message."\n        ---\n        stacktrace: |\n".$stacktrace."\n        ...\n";
	}

	public function			reportUnthrown($testObject, $method, $index, $totalIndex, $expectedException)
	{
		return "expected test to throw an exception: ".$expectedException."\n";
	}

	public function			reportException($testObject, $method, $index, $totalIndex, $ex)
	{
		return "exception thrown (".get_class($ex)."): ".\net\dryuf\core\Exception::formatReport($ex, 2);
	}
}


?>
