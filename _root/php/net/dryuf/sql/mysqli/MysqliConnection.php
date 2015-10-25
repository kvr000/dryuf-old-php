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


class MysqliConnection extends \net\dryuf\sql\AbstractConnection
{
	static function			openNew($connect_str)
	{
		return new \net\dryuf\sql\mysqli\MysqliConnection($connect_str);
	}

	function			__construct($connect_str)
	{
		$connect_str = ";".trim($connect_str).";";
		if (!preg_match("/;host=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "host not specified");
		$host = $vals[1];
		if (!preg_match("/;user=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "user not specified");
		$user = $vals[1];
		if (!preg_match("/;pass=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "pass not specified");
		$pass = $vals[1];
		if (!preg_match("/;db=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "db not specified");
		$db = $vals[1];
		$port = preg_match("/;port=([^;]*);/", $connect_str, $vals) ? $vals[1] : null;

		if (!($this->mysql_handle = mysqli_connect($host, $user, $pass, $db, $port))) {
			throw new \net\dryuf\sql\SqlException(-1, -1, "failed to connect: ".mysqli_connect_error());
		}
		$this->runDirect("SET CHARSET 'UTF8'");
		foreach (array("character_set_server", "character_set_database", "character_set_connection", "character_set_client", "character_set_results") as $cset)
			$this->runDirect("SET $cset='UTF8'");

		$this->dialect = new \net\dryuf\sql\mysqli\MysqliSqlDialect();
	}

	function			close()
	{
		$this->storeRunningStatement();
		$this->mysql_handle = null;
	}

	function			getDriver()
	{
		return __CLASS__;
	}

	function			setAutoCommit($enable)
	{
		$this->storeRunningStatement();
		if (!\mysqli_autocommit($this->mysql_handle, $enable))
			$this->throwSqlException();
	}

	function			doCommit()
	{
		$this->storeRunningStatement();
		if (!\mysqli_commit($this->mysql_handle))
			$this->throwSqlException();
	}

	function			doRollback()
	{
		$this->storeRunningStatement();
		if (!\mysqli_rollback($this->mysql_handle))
			$this->throwSqlException();
	}

	function			hasExplicitSerial()
	{
		return null;
	}

	function			addOffsetLimit($statement, &$binds, $offset, $limit)
	{
		array_push($binds, $offset, $limit);
		return $statement." LIMIT ?, ?";
	}

	function			addOffsetLimitRef($statement, &$refBinds, $offset, $limit)
	{
		array_push($refBinds, $offset, $limit);
		return $statement." LIMIT ?, ?";
	}

	function			needDeleteAliasFrom()
	{
		return true;
	}

	function			escapeString($str)
	{
		return \mysqli_real_escape_string($this->mysql_handle, $str);
	}

	function			conversionFrom($type, $expr)
	{
		switch ($type) {
		case 'date':
			return "unix_timestamp($expr)";

		case 'datetime':
		case 'timestamp':
			return "unix_timestamp($expr)";

		case 'enum':
			return "$expr-1";

		case 'set':
			return "$expr+0";

		default:
			throw new \net\dryuf\core\Exception("invalid conversion: $type");
		}
	}

	function			conversionTo($type, $expr)
	{
		switch ($type) {
		case 'date':
			return "from_unixtime($expr)";

		case 'datetime':
		case 'timestamp':
			return "from_unixtime($expr)";

		case 'enum':
			return "$expr+1";

		case 'set':
			return $expr;

		default:
			throw new \net\dryuf\core\Exception("invalid conversion: $type");
		}
	}

	function			prepareStatement($statement)
	{
		if (!($stmt = \mysqli_prepare($this->mysql_handle, $statement))) {
			throw new \net\dryuf\sql\SqlParseException($statement, \mysqli_sqlstate($this->mysql_handle), -1, \mysqli_error($this->mysql_handle));
		}
		return new \net\dryuf\sql\mysqli\MysqliStatement($this, $stmt, $statement);
	}

	function			runDirect($statement)
	{
		if (!\mysqli_query($this->mysql_handle, $statement)) {
			throw new \net\dryuf\sql\SqlException(\mysqli_sqlstate($this->mysql_handle), \mysqli_errno($this->mysql_handle), \mysqli_error($this->mysql_handle));
		}
	}

	function			ping()
	{
		$this->storeRunningStatement();
		if (!\mysqli_ping($this->mysql_handle))
			throw new \net\dryuf\sql\SqlException(\mysqli_sqlstate($this->mysql_handle), \mysqli_errno($this->mysql_handle), \mysqli_error($this->mysql_handle));
	}

	function			throwSqlException()
	{
		$state = \mysqli_sqlstate($this->mysql_handle);
		if ($state == 23000) {
			$desc = \mysqli_error($this->mysql_handle);
			$contraint = "";
			if (preg_match("/\'([^\']*)\'[^\']*$/", $desc, $match))
				$constraint = $match[1];
			throw new \net\dryuf\sql\SqlUniqueConstraintException($state, \mysqli_errno($this->mysql_handle), $desc, $constraint);
		}
		throw new \net\dryuf\sql\SqlException($state, \mysqli_errno($this->mysql_handle), \mysqli_error($this->mysql_handle));
	}

	function			setRunningStatement($statement)
	{
		$this->runningStatement = $statement;
	}

	function			storeRunningStatement()
	{
		if (!is_null($this->runningStatement)) {
			if (!mysqli_stmt_store_result($this->runningStatement)) {
				throw new \net\dryuf\sql\SqlException(mysqli_stmt_sqlstate($this->runningStatement), \mysqli_errno($this->mysql_handle), mysqli_stmt_error($this->runningStatement));
			}
			$this->runningStatement = null;
		}
	}

	function			removeRunningStatement($statement)
	{
		if ($this->runningStatement == $statement)
			$this->runningStatement = null;
	}

	public				$mysql_handle;

	public				$runningStatement;

	const				ER_DUP_KEY			= 1022;
	const				ER_DUP_ENTRY			= 1062;
	const				ER_DUP_ENTRY_WITH_KEY_NAME	= 1586;
	const				ER_DUP_ENTRY_AUTOINCREMENT_CASE	= 1569;
	const				ER_DUP_UNIQUE			= 1169;
	const				ER_BAD_NULL_ERROR		= 1048;
	const				ER_NO_REFERENCED_ROW		= 1216;
	const				ER_NO_REFERENCED_ROW_2		= 1452;
	const				ER_ROW_IS_REFERENCED		= 1217;
	const				ER_ROW_IS_REFERENCED_2		= 1451;
};


?>
