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


class Sqlite3Connection implements \net\dryuf\sql\Connection
{
	static function			openNew($connect_str)
	{
		return new \net\dryuf\sql\sqlite3\Sqlite3Connection($connect_str);
	}

	function			__construct($connect_str)
	{
		$connect_str = ";".trim($connect_str).";";
		if (!preg_match("/;file=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "file not specified");
		$file = $vals[1];

		if (!preg_match("/;open_mode=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "open flags not specified");
		$open = intval($vals[1]);

		try {
			$this->sqlite3_handle = new \SQLite3($file, $open);
		}
		catch (Exception $ex) {
			throw new \net\dryuf\sql\SqlException(-1, -1, "failed to connect: ".$ex->__toString());
		}
	}

	function			close()
	{
		$this->sqlite3_handle = null;
	}

	function			getDriver()
	{
		return __CLASS__;
	}

	function			getErrorCode()
	{
		return $this->sqlite3_handle->lastErrorCode();
	}

	function			getErrorMessage()
	{
		return $this->sqlite3_handle->lastErrorMsg();
	}

	function			setAutoCommit($enable)
	{
		if ($enable) {
			if ($this->transctioned)
				$this->commit();
		}
		else {
			if (!$this->transactioned) {
				$this->runDirect("BEGIN");
				$this->transactioned = true;
			}
		}
	}

	function			commit()
	{
		$this->transactioned = false;
		$this->runDirect("COMMIT");
	}

	function			rollback()
	{
		$this->transactioned = false;
		$this->runDirect("ROLLBACK");
	}

	function			hasExplicitSerial()
	{
		return null;
	}

	function			addOffsetLimit(&$statement, &$binds, $offset, $limit)
	{
		array_push($binds, $offset, $limit);
		return $statement." LIMIT ?, ?";
	}

	function			addOffsetLimitRef(&$statement, &$refBinds, $offset, $limit)
	{
		array_push($refBinds, $offset, $limit);
		return $statement." LIMIT ?, ?";
	}

	function			needDeleteAliasFrom()
	{
		return false;
	}

	function			escapeString($str)
	{
		return SQLite3::escapeString($str);
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

	function			getDialect()
	{
	}

	static function			skipString($str, $p)
	{
		$char = substr($str, $p, 1);
		for (;;) {
			if (($e = strpos($str, $char, $p+1)) === false)
				throw new \net\dryuf\sql\SqlParseException($statement_cv, -1, -1, "end of string starting at ".$p." not found");
			if (($b = strpos($str, "\\", $p+1)) !== false && $b < $e) {
				$p = $b+1;
				continue;
			}
			return $e+1;
		}
	}

	function			prepareStatement($statement)
	{
		$statement_cv = $statement;
		for ($p = 0, $id = 0; ; ) {
			if (($c = strpos($statement_cv, '?', $p)) === false)
				break;
			if (($q = strpos($statement_cv, "'", $p)) !== false && $q < $c) {
				$p = self::skipString($statement_cv, $q);
				continue;
			}
			if (($q = strpos($statement_cv, "\"", $p)) !== false && $q < $c) {
				$p = self::skipString($statement_cv, $q);
				continue;
			}
			$statement_cv = substr($statement_cv, 0, $c).":v".$id.substr($statement_cv, $c+1);
			$id++;
		}
		if (!($stmt = $this->sqlite3_handle->prepare($statement_cv))) {
			throw new \net\dryuf\sql\SqlParseException($statement_cv, $this->sqlite3_handle->lastErrorCode(), $this->sqlite3_handle->lastErrorCode(), $this->sqlite3_handle->lastErrorMsg($this->sqlite3_handle));
		}
		return new \net\dryuf\sql\sqlite3\Sqlite3Statement($this, $stmt, $id);
	}

	function			runDirect($statement)
	{
		assert(!is_null($this->sqlite3_handle), "not closed");
		if (!$this->sqlite3_handle->query($statement)) {
			$this->throwSqlException();
		}
	}

	function			ping()
	{
	}

	function			throwSqlException()
	{
		throw new \net\dryuf\sql\SqlException($this->sqlite3_handle->lastErrorCode(), $this->sqlite3_handle->lastErrorCode(), $this->sqlite3_handle->lastErrorMsg());
	}

	public				$sqlite3_handle;

	protected			$transactioned;
};


?>
