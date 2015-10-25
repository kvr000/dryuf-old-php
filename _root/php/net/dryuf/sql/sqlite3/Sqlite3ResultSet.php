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

namespace net\dryuf\sql\sqlite3;


class Sqlite3ResultSet implements \net\dryuf\sql\ResultSet
{
	function			__construct($statement_owner, $resultSet)
	{
		$this->statement_owner = $statement_owner;
		$this->resultSet = $resultSet;
		$this->statement = $statement_owner->statement;
	}

	function			__destruct()
	{
		$this->close();
	}

	function			next()
	{
		if (($this->row = $this->resultSet->fetchArray(SQLITE3_NUM)) === false)
			return false;
		return true;
	}

	function			nextArray()
	{
		if (($this->row = $this->resultSet->fetchArray(SQLITE3_NUM)) === false)
			return null;
		return $row;
	}

	function			nextAssoc()
	{
		if (($this->row = $this->resultSet->fetchArray(SQLITE3_ASSOC)) === false)
			return null;
		return $row;
	}

	function			getObject($i)
	{
		return $this->row[$i-1];
	}

	function			getArray()
	{
		return $this->row;
	}

	function			getMapped()
	{
		$map = new \net\dryuf\util\php\NativeHashMap();
		$names = $this->getNames();
		for ($i = 0; $i < count($names); ++$i)
			$map->put($names[$i], $this->row[$i]);
		return $map;
	}

	function			getNames()
	{
		if (is_null($this->names)) {
			$this->names = array();
			for ($i = 0, $cn = $this->resultSet->numColumns(); $i < $cn; $i++) {
				array_push($this->names, $this->resultSet->columnName($i));
			}
		}
		return $this->names;
	}

	function			store()
	{
	}

	function			close()
	{
	}

	public				$statement_owner;
	public				$resultSet;
	public				$statement;
	public				$row;
	public				$names;
};


?>
