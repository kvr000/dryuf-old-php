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

namespace net\dryuf\sql\mysqli;


class MysqliResultSet implements \net\dryuf\sql\ResultSet
{
	function			__construct($statement_owner)
	{
		$this->statement_owner = $statement_owner;
		$this->statement = $statement_owner->statement;
		$this->internalBindResult();
	}

	function			__destruct()
	{
		$this->close();
	}

	function			next()
	{
		return mysqli_stmt_fetch($this->statement);
	}

	function			nextArray()
	{
		if (!mysqli_stmt_fetch($this->statement))
			return null;
		return $this->row;
	}

	function			nextAssoc()
	{
		if (!mysqli_stmt_fetch($this->statement))
			return null;
		if (!isset($this->names)) {
			$this->names = array();
			$fields = mysqli_fetch_fields(mysqli_stmt_result_metadata($this->statement));
			foreach ($fields as $field) {
				array_push($this->names, $field->name);
			}
		}
		$res = array();
		for ($i = 0; $i < count($this->names); $i++) {
			$res[$this->names[$i]] = $this->row[$i];
		}
		return $res;
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
			$fields = mysqli_fetch_fields(mysqli_stmt_result_metadata($this->statement));
			foreach ($fields as $field) {
				array_push($this->names, $field->name);
			}
		}
		return $this->names;
	}

	function			store()
	{
		$this->statement_owner->connection->storeRunningStatement();
	}

	function			close()
	{
		if (isset($this->statement)) {
			mysqli_stmt_reset($this->statement);
			$this->statement_owner->connection->removeRunningStatement($this->statement);
			$this->statement = null;
		}
	}

	function			internalBindResult()
	{
		$this->row = array();
		for ($i = mysqli_stmt_field_count($this->statement); $i-- > 0; ) {
			array_push($this->row, null);
		}
		for ($i = 0; $i < count($this->row); $i++) {
			$args[$i] = &$this->row[$i];
		}
		array_unshift($args, $this->statement);
		if (!call_user_func_array("mysqli_stmt_bind_result", $args))
			$this->statement_owner->throwException();
	}

	public				$statement_owner;
	public				$statement;
	public				$names;

	public				$row;
};


?>
