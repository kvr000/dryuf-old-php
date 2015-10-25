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


class Sqlite3Statement implements \net\dryuf\sql\Statement
{
	function			__construct($connection, $statement, $parCount)
	{
		$this->connection = $connection;
		$this->statement = $statement;
		$this->parCount = $parCount;
	}

	function			bindParams($binds)
	{
		if (!is_array($binds)) {
			throw new \net\dryuf\sql\SqlException(-1, -1, "expects binds to be an array");
		}
		if (count($binds) == 0)
			return;
		if (count($binds) != $this->parCount)
			throw new \net\dryuf\sql\SqlException(-1, -1, "invalid number of binds");
		for ($i = 0; $i < count($binds); $i++) {
			$this->statement->bindValue("v".$i, $binds[$i]);
		}
		return $this;
	}

	function			executeQuery()
	{
		if (!($rs = $this->statement->execute()))
			$this->throwException();
		return new \net\dryuf\sql\sqlite3\Sqlite3ResultSet($this, $rs);
	}

	function			executeUpdate()
	{
		if (!$this->statement->execute())
			$this->throwException();
		return $this->connection->sqlite3_handle->changes();
	}

	function			getInsertId()
	{
		return $this->connection->sqlite3_handle->lastInsertRowID();
	}

	function			throwException()
	{
		$state = $this->connection->getErrorCode();
		#if ($state == 23000) {
		#	$desc = mysqli_stmt_error($this->statement);
		#	$contraint = "";
		#	if (preg_match("/\'([^\']*)\'[^\']*$/", $desc, $match))
		#		$constraint = $match[1];
		#	throw new \net\dryuf\sql\SqlUniqueConstraintException($state, $desc, $constraint);
		#}
		throw new \net\dryuf\sql\SqlException($state, $this->connection->getErrorCode(), $this->connection->getErrorMessage());
	}

	public				$connection;
	public				$statement;
	public				$parCount;
};


?>
