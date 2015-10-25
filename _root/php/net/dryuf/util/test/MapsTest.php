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


class MapsTest
{
	function			doTests($map)
	{
		$map->put("a", 0);
		$map->put("b", 1);
		$map->put("c", 2);
		$map->put("d", 3);
		$map->put("e", 4);
		$map->put("f", 5);
		$map->get("a", 5);
		$map->put("e", 7);
		\net\dryuf\tenv\DAssert::assertEquals(6, $map->size(), "size == 6");
		$this->counter = 0;
		$map->forEachDo(function ($key, $value) { $this->counter += $value; });
		\net\dryuf\tenv\DAssert::assertEquals(18, $this->counter);
	}

	/**
	 * @org.junit.Test
	 */
	function                        testHashMap()
	{
		$map = new \net\dryuf\util\HashMap();
		$this->doTests($map);
	}

	/**
	 * @org.junit.Test
	 */
	function                        testLinkedHashMap()
	{
		$map = new \net\dryuf\util\LinkedHashMap();
		$map->put("x", 0);
		$map->put("y", 1);
		$map->put("z", 2);
		$map->put("a", 3);
		$map->put("b", 4);
		$map->put("c", 5);
		$map->get("a", 5);
		$map->put("x", 7);
		$k = $map->keySet();
		\net\dryuf\tenv\DAssert::assertEquals("x", $k->get(0));
		\net\dryuf\tenv\DAssert::assertEquals("y", $k->get(1));
		\net\dryuf\tenv\DAssert::assertEquals("z", $k->get(2));
		\net\dryuf\tenv\DAssert::assertEquals("a", $k->get(3));
		\net\dryuf\tenv\DAssert::assertEquals("b", $k->get(4));
		\net\dryuf\tenv\DAssert::assertEquals("c", $k->get(5));
	}

	protected			$counter = 0;
}


?>
