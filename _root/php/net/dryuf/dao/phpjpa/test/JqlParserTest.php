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

namespace net\dryuf\dao\phpjpa\test;


class JqlParserTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	 * @org.junit.Test
	 */
	function                        testParsingSelect()
	{
		$tree = (new \net\dryuf\dao\phpjpa\parser\JqlParser())->parse("SELECT u, u.username FROM UserAccount u WHERE u.userId = ?1");
		\net\dryuf\tenv\DAssert::assertClass("net.dryuf.dao.phpjpa.parser.SelectTree", $tree, "result must be SelectTree");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testParsingDelete()
	{
		$tree = (new \net\dryuf\dao\phpjpa\parser\JqlParser())->parse("DELETE UserAccount WHERE u.userId = ?1");
		\net\dryuf\tenv\DAssert::assertClass("net.dryuf.dao.phpjpa.parser.DeleteTree", $tree, "result must be DeleteTree");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testParsingUpdate()
	{
		$tree = (new \net\dryuf\dao\phpjpa\parser\JqlParser())->parse("UPDATE UserAccount SET username = :name WHERE u.userId = ?1");
		\net\dryuf\tenv\DAssert::assertClass("net.dryuf.dao.phpjpa.parser.UpdateTree", $tree, "result must be UpdateTree");
	}
}


?>
