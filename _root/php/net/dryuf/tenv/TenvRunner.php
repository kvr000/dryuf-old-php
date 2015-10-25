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

namespace net\dryuf\tenv;


class TenvRunner
{
	function			__construct($presenter, $reporter)
	{
		$this->presenter = $presenter;
		$this->callerContext = $presenter->getCallerContext();
		$this->reporter = $reporter;
	}

	function			getCallerContext()
	{
		return $this->callerContext;
	}

	function			getPresenter()
	{
		return $this->presenter;
	}

	function			runTests($testClasses)
	{
		$this->classCount = count($testClasses);
		$this->totalCount = 0;

		foreach ($testClasses as $testClass) {
			if (preg_match('/^(.*)\.([a-z]\w*)$/', $testClass)) {
				$allClasses[$testClass] = 1;
				$this->totalCount++;
			}
			else {
				try {
					$localCount = 0;
					foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($testClass, "org.junit.Test") as $method => $testAnno) {
						if (!is_null(\net\dryuf\core\Dryuf::getMethodAnnotation($testClass, $method, 'org.junit.Ignore')))
							continue;
						++$localCount;
					}
					$allClasses[$testClass] = $localCount;
					$this->totalCount += $localCount;
				}
				catch (\Exception $ex) {
					$allClasses[$testClass] = $ex;
					$this->totalCount += 1;
				}
			}
		}

		$this->reporter->reportAllStart($this->classCount, $this->totalCount);

		$this->classFailed = 0;
		$this->totalFailed = 0;
		$this->totalIndex = 0;

		foreach ($allClasses as $testClass => $count) {
			if ($count instanceof \Exception) {
				$this->reporter->reportClassCreateFailure($testClass, $this->totalIndex, $count);
				++$this->totalIndex;
			}
			else {
				$this->runTestClass($testClass);
			}
		}

		$this->reporter->reportAllEnd($this->classCount, $this->classFailed, $this->totalCount, $this->totalFailed);
		return $this->totalFailed != 0 ? 1 : 0;
	}

	function			processBefore($testObject)
	{
		$testClass = get_class($testObject);
		foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($testClass, "org.junit.Before") as $method => $testAnno) {
			$testObject->$method();
		}
	}

	function			processAfter($testObject)
	{
		$testClass = get_class($testObject);
		foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($testClass, "org.junit.After") as $method => $testAnno) {
			$testObject->$method();
		}
	}

	function			runTestClass($testClass)
	{
		$localCount = 0;
		$localFailed = 0;
		$timeStart = microtime(true)*1000;
		$methods = array();
		if (preg_match('/^(.*)\.([a-z]\w*)$/', $testClass, $m)) {
			$testClass = $m[1];
			$methods[$m[2]] = \net\dryuf\core\Dryuf::getMethodAnnotation($testClass, $m[2], 'org.junit.Test');
			++$localCount;
		}
		else {
			foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($testClass, "org.junit.Test") as $method => $testAnno) {
				if (!is_null(\net\dryuf\core\Dryuf::getMethodAnnotation($testClass, $method, 'org.junit.Ignore')))
					continue;
				$methods[$method] = $testAnno;
				++$localCount;
			}
		}
		try {
			$testObject = $this->presenter->getCallerContext()->createBeaned($testClass, null);
		}
		catch (\Exception $ex) {
			while ($localCount-- > 0) {
				$this->reporter->reportClassCreateFailure($testClass, $this->totalIndex++, $ex);
			}
			return;
		}
		$this->reporter->reportClassStart($testObject, $localCount);
		$localIndex = 0;
		foreach ($methods as $method => $testAnno) {
			$timeMethodStart = microtime(true)*1000;
			$this->reporter->reportMethodStart($testObject, $method, $localIndex, $this->totalIndex);
			$ok = 1;
			try {
				$this->processBefore($testObject);
			}
			catch (\Exception $ex) {
				$error = $this->reporter->reportException($testObject, $method, $localIndex, $this->totalIndex, $ex);
				$ok = -1;
			}
			if ($ok > 0) {
				try {
					call_user_func(array($testObject, $method));
					if ($testAnno->expected() != "org.junit.Test.None") {
						$error = $this->reporter->reportUnthrown($testObject, $method, $localIndex, $this->totalIndex, $testAnno->expected());
						$ok = 0;
					}
				}
				catch (\Exception $ex) {
					$refEx = new \ReflectionClass(get_class($ex));
					if (!$refEx->isSubclassOf(\net\dryuf\core\Dryuf::convertClassname($testAnno->expected())) && get_class($ex) != $testAnno->expected()) {
						$error = $this->reporter->reportException($testObject, $method, $localIndex, $this->totalIndex, $ex);
						$ok = 0;
					}
				}
			}
			if ($ok >= 0) {
				try {
					$this->processAfter($testObject);
				}
				catch (\Exception $ex) {
					$error = $this->reporter->reportException($testObject, $method, $localIndex, $this->totalIndex, $ex);
					$ok = -1;
				}
			}
			if ($ok > 0) {
				$error = $this->reporter->reportSuccess($testObject, $method, $localIndex, $this->totalIndex);
			}
			else {
				++$this->totalFailed;
				++$localFailed;
			}
			$timeMethodEnd = microtime(true)*1000;
			$this->reporter->reportMethodEnd($testObject, $method, $localIndex, $this->totalIndex, $error, $timeMethodEnd-$timeMethodStart);
			++$localIndex;
			++$this->totalIndex;
		}
		$timeEnd = microtime(true)*1000;
		$this->reporter->reportClassEnd($testObject, $localIndex, $localFailed, $timeEnd-$timeStart);
		return $localFailed != 0 ? 1 : 0;
	}

	protected			$presenter;
	protected			$callerContext;
	protected			$reporter;

	protected			$classCount			= 0;
	protected			$classFailed			= 0;
	protected			$totalCount			= 0;
	protected			$totalFailed			= 0;
	protected			$totalIndex			= 0;
}


?>
