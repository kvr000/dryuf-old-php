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


abstract class DAssert extends \net\dryuf\core\Object
{
	static function			fail($message = null)
	{
		throw new \net\dryuf\tenv\TestException("Test failed: ".$message);
	}

	static function			assertTrue($cond, $message = null)
	{
		if (!$cond)
			throw new \net\dryuf\tenv\TestException("Test true failed".($message ? ": ".$message : ""));
	}

	static function			assertFalse($cond, $message = null)
	{
		if ($cond)
			throw new \net\dryuf\tenv\TestException("Test false failed".($message ? ": ".$message : ""));
	}

	static function			assertNull($value, $message = null)
	{
		if (!is_null($value))
			throw new \net\dryuf\tenv\TestException("Test null failed, got: '".$value."'".($message ? ": ".$message : ""));
	}

	static function			assertNotNull($value, $message = null)
	{
		if (is_null($value))
			throw new \net\dryuf\tenv\TestException("Test notnull failed".($message ? ": ".$message : ""));
	}

	static function			assertEquals($expected, $actual, $message = null)
	{
		if (!\net\dryuf\core\Dryuf::equalObjects($expected, $actual))
			throw new \net\dryuf\tenv\TestException(($message ? $message : "Test equals failed").": expected=".strval($expected).", actual=".strval($actual));
	}

	static function			assertNotEquals($expected, $actual, $message = null)
	{
		if (\net\dryuf\core\Dryuf::equalObjects($expected, $actual))
			throw new \net\dryuf\tenv\TestException(($message ? $message : "Test not equals failed").": expected=".strval($expected).", actual=".strval($actual));
	}

	static function			assertEqualsPercent1($expected, $actual, $message = null)
	{
		$d0 = abs($expected);
		$d1 = abs($actual);
		if ($d0 < $d1)
			$d0 = $d1;
		$diff = $d0/100;
		if (abs($expected-$actual) > $diff)
			throw new \net\dryuf\tenv\TestException(($message ? $message : "Test equals failed").": expected=".strval($expected).", actual=".strval($actual));
	}

	static function			assertNotEqualsPercent1($expected, $actual, $message = null)
	{
		$d0 = abs($expected);
		$d1 = abs($actual);
		if ($d0 < $d1)
			$d0 = $d1;
		$diff = $d0/100;
		if (abs($expected-$actual) <= $diff)
			throw new \net\dryuf\tenv\TestException(($message ? $message : "Test not equals failed").": expected=".strval($expected).", actual=".strval($actual));
	}

	static function			assertArrayEquals($expected, $actual, $message = null)
	{
		if (!is_array($expected) || !is_array($actual))
			throw new \net\dryuf\tenv\TestException(($message ? $message : "Array not arrays")." : expected=".gettype($expected).", actual=".gettype($actual));
		if (is_null($expected) || is_null($actual)) {
			if ($actual != $expected)
				throw new \net\dryuf\tenv\TestException(($message ? $message : "Arrays not equal")." : expected.length=".(is_null($expected) ? "null" : count($expected)).", actual.length=".(is_null($actual) ? "null" : count($actual)));
			return;
		}
		if (count($actual) != count($expected)) {
			throw new \net\dryuf\tenv\TestException(($message ? $message : "Arrays not equal")." : expected.length=".count($expected).", actual.length=".count($actual));
		}
		for ($i = 0; $i < count($actual); ++$i) {
			if (!\net\dryuf\core\Dryuf::equalObjects($expected[$i], $actual[$i]))
				throw new \net\dryuf\tenv\TestException(($message ? $message : "Arrays not equal")." : expected[$i]=".$expected[$i].", actual[$i]=".$actual[$i]);
		}
	}

	static function			assertArrayNotEquals($expected, $actual, $message = null)
	{
		if (!is_array($expected) || !is_array($actual))
		if (is_null($expected) || is_null($actual)) {
			if ($actual != $expected)
				return;
		}
		if (count($actual) != count($expected)) {
			return;
		}
		for ($i = 0; $i < count($actual); ++$i) {
			if (!\net\dryuf\core\Dryuf::equalObjects($expected[$i], $actual[$i]))
				return;
		}
		throw new \net\dryuf\tenv\TestException($message ? $message : "Array equal");
	}

	static function			assertClass($clazz, $value, $message = null)
	{
		if (get_class($value) != \net\dryuf\core\Dryuf::convertClassname($clazz))
			throw new \net\dryuf\tenv\TestException("Test of class failed: real=".get_class($value).", expected=".$clazz.($message ? ": ".$message : ""));
	}

	static function			assertInstanceOf($clazz, $value, $message = null)
	{
		if (is_null($value))
			throw new \net\dryuf\tenv\TestException("Null pointer: ".$message);
		if (!is_object($value))
			throw new \net\dryuf\tenv\TestException("Expected $clazz, got: ".gettype($value));
		$valueClazz = get_class($value);
		$refClazz = new \ReflectionClass($valueClazz);
		if ($valueClazz != \net\dryuf\core\Dryuf::convertClassname($clazz) && !$refClazz->isSubclassOf(\net\dryuf\core\Dryuf::convertClassname($clazz)))
			throw new \net\dryuf\tenv\TestException("Test of class failed: expected=".$clazz.", actual=".$valueClazz.($message ? ": ".$message : ""));
	}
}


?>
