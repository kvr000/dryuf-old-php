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


class MysqliStatement implements \net\dryuf\sql\Statement
{
	function			__construct($connection, $statement, $statementString)
	{
		$this->connection = $connection;
		$this->statement = $statement;
		$this->statementString = $statementString;
	}

	function			bindParams($binds)
	{
		if (!is_array($binds)) {
			throw new \net\dryuf\core\Exception("expects binds to be an array");
		}
		if (count($binds) == 0)
			return;
		$types = "";
		$args = array($this->statement, &$types);
		for ($i = 0; $i < count($binds); $i++) {
			$a = $binds[$i];
			if (is_int($a))
				$types .= "i";
			else if (is_double($a))
				$types .= "d";
			else
				$types .= "s";
			$args[count($args)] = &$binds[$i];
		}
		try {
			if (!call_user_func_array("mysqli_stmt_bind_param", $args))
				$this->throwException();
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\sql\SqlException(-1, \mysqli_errno($this->connection->mysql_handle), "failed to bind $this->statementString: ".strval($ex));
		}
		return $this;
	}

	function			executeQuery()
	{
		$this->connection->storeRunningStatement();

		if (!mysqli_stmt_execute($this->statement))
			$this->throwException();

		$this->connection->setRunningStatement($this->statement);

		return new \net\dryuf\sql\mysqli\MysqliResultSet($this, $this->statement);
	}

	function			executeUpdate()
	{
		$this->connection->storeRunningStatement();

		if (!mysqli_stmt_execute($this->statement))
			$this->throwException();

		if (preg_match('/^[^:]*:\s*(\d+)/', mysqli_info($this->connection->mysql_handle), $m))
			return $m[1];
		return mysqli_stmt_affected_rows($this->statement);
	}

	function			getInsertId()
	{
		if (($id = mysqli_stmt_insert_id($this->statement)) == 0) {
			$this->throwException();
		}
		return $id;
	}

	function			throwException()
	{
		$state = mysqli_stmt_sqlstate($this->statement);
		if ($state == 23000) {
			$desc = mysqli_stmt_error($this->statement);
			$contraint = "";
			if (preg_match("/\'([^\']*)\'[^\']*$/", $desc, $match))
				$constraint = $match[1];
			throw new \net\dryuf\sql\SqlUniqueConstraintException($state, \mysqli_errno($this->connection->mysql_handle), $desc, $constraint);
		}
		throw new \net\dryuf\sql\SqlException($state, mysqli_stmt_error($this->statement), \mysqli_errno($this->connection->mysql_handle));
	}

	public				$connection;
	public				$statement;
	public				$statementString;
};


?>
