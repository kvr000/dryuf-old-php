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

namespace net\dryuf\util\test;


class SetsTest
{
	function			doTests($set)
	{
		$set->add("a");
		$set->add("b");
		$set->add("c");
		$set->add("d");
		$set->add("e");
		$set->add("f");
		\net\dryuf\tenv\DAssert::assertTrue($set->contains("a"));
		$set->add("e");
		\net\dryuf\tenv\DAssert::assertEquals(6, $set->size(), "size == 6");
		\net\dryuf\tenv\DAssert::assertEquals(6, count($set->toArray()));
	}

	/**
	 * @org.junit.Test
	 */
	function                        testHashSet()
	{
		$set = new \net\dryuf\util\HashSet();
		$this->doTests($set);
	}

	/**
	 * @org.junit.Test
	 */
	function                        testLinkedHashMap()
	{
		$set = new \net\dryuf\util\LinkedHashSet();
		$set->add("x");
		$set->add("y");
		$set->add("z");
		$set->add("a");
		$set->add("b");
		$set->add("c");
		\net\dryuf\tenv\DAssert::assertTrue($set->contains("a"));
		$set->add("x");
		$k = $set->toArray();
		\net\dryuf\tenv\DAssert::assertEquals("x", $k[0]);
		\net\dryuf\tenv\DAssert::assertEquals("y", $k[1]);
		\net\dryuf\tenv\DAssert::assertEquals("z", $k[2]);
		\net\dryuf\tenv\DAssert::assertEquals("a", $k[3]);
		\net\dryuf\tenv\DAssert::assertEquals("b", $k[4]);
		\net\dryuf\tenv\DAssert::assertEquals("c", $k[5]);
	}
}


?>
