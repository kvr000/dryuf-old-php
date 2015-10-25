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


class ListsTest
{
	function			doTests($list)
	{
		$list->add(0);
		$list->add(1);
		\net\dryuf\tenv\DAssert::assertTrue($list->size() == 2, "size() == 2");
		$list->listIterator(1)->add(3);
		\net\dryuf\tenv\DAssert::assertTrue($list->size() == 3, "size() == 3");
		\net\dryuf\tenv\DAssert::assertTrue($list->get(1) == 3, "get(1) == 3");
		$count = 0;
		$last = null;
		foreach ($list as $item) {
			++$count;
			$last = $item;
		}
		\net\dryuf\tenv\DAssert::assertEquals(3, $count, "iterator == 3");
		\net\dryuf\tenv\DAssert::assertEquals(1, $last, "last == 1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testLinkedList()
	{
		$list = new \net\dryuf\util\LinkedList();
		$this->doTests($list);
	}

	/**
	 * @org.junit.Test()
	 */
	function                        testArrayList()
	{
		$list = new \net\dryuf\util\ArrayList();
		$this->doTests($list);
	}
}


?>
