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

namespace net\dryuf\sql\pgsql;


class PgsqlSqlDialect extends \net\dryuf\sql\AbstractSqlDialect
{
	function			getDialectName()
	{
		return __CLASS__;
	}

	function			conversionFrom($type, $expr)
	{
		throw new \RuntimeException("unimplemented");
	}

	function			conversionTo($type, $expr)
	{
		throw new \RuntimeException("unimplemented");
	}

	function			addOffsetLimitRef($statement, &$refBinds, $offset, $limit)
	{
		array_push($refBinds, $offset);
		array_push($refBinds, $limit);
		return $statement." LIMIT ?, ?";
	}

	function			needDeleteAliasFrom()
	{
		return true;
	}
}


?>