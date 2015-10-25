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


class TextReporter extends \net\dryuf\tenv\reporter\AbstractReporter
{
	function			__construct($presenter)
	{
		parent::__construct($presenter);
	}

	public function			reportClassCreateFailure($testClass, $totalIndex, $ex)
	{
		$this->output("test-class-err:\t".$testClass."\n");
	}

	public function			reportClassStart($testObject, $count)
	{
		$this->output("test-class-go:\t".get_class($testObject)."\n");
	}

	public function			reportClassEnd($testObject, $count, $failed, $millitime)
	{
		$this->output("test-class-end:\t".get_class($testObject).": ".($count-$failed)."/".$count.", time=".number_format($millitime/1000.0, 3, ".", "")."s\n");
	}

	public function			reportMethodStart($testObject, $method, $index, $totalIndex)
	{
		$this->output("\ttest-go:\t".get_class($testObject).".$method\n");
	}

	public function			reportMethodEnd($testObject, $method, $index, $totalIndex, $error, $millitime)
	{
		$this->output("\ttest-end:\t".get_class($testObject).".".$method.": result=".(is_null($error) ? 1 : 0).", time=".number_format($millitime/1000.0, 3, ".", "")."s\n");
	}

	public function			reportUnthrown($testObject, $method, $index, $totalIndex, $expectedException)
	{
		$this->output("\t\tunthrown:\t".get_class($testObject).".".$method.": expected test to throw an exception: ".$expectedException);
	}

	public function			reportException($testObject, $method, $index, $totalIndex, $ex)
	{
		$this->output("\t\tfailure:\t".get_class($testObject).".".$method.": exception thrown: ".trim(preg_replace('/^/m', "\t\t\t", \net\dryuf\core\Exception::formatReport($ex, 2)))."\n");
	}
}


?>
