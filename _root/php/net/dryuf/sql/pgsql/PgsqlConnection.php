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


class PgsqlConnection extends \net\dryuf\sql\AbstractConnection
{
	static function			openNew($connect_str)
	{
		return new \net\dryuf\sql\pgsql\PgsqlConnection($connect_str);
	}

	function			__construct($connect_str)
	{
		$connect_str = ";".trim($connect_str).";";
		$par = "options='--client_encoding=UTF8'";
		if (preg_match("/;host=([^;]*);/", $connect_str, $vals))
			$par .= " host=$vals[1]";
		if (preg_match("/;user=([^;]*);/", $connect_str, $vals))
			$par .= " user=$vals[1]";
		if (preg_match("/;pass=([^;]*);/", $connect_str, $vals))
			$par .= " pass=$vals[1]";
		if (preg_match("/;port=([^;]*);/", $connect_str, $vals))
			$par .= " port=$vals[1]";
		if (!preg_match("/;db=([^;]*);/", $connect_str, $vals))
			throw new \net\dryuf\sql\SqlException(-1, -1, "db not specified");
		$par .= " dbname=$vals[1]";

		if (!($this->pg_handle = \pg_connect($par))) {
			throw new \net\dryuf\sql\SqlException(-1, -1, "failed to connect: ".\pg_last_error());
		}

		$this->dialect = new \net\dryuf\sql\pgsql\PgsqlSqlDialect();
	}

	function			close()
	{
		$this->pg_handle = null;
	}

	function			getDriver()
	{
		return __CLASS__;
	}

	function			setAutoCommit($enable)
	{
		if ($enable)
			$this->runDirect("BEGIN");
		else
			$this->commit();
	}

	function			doCommit()
	{
		$this->runDirect("COMMIT");
	}

	function			doRollback()
	{
		$this->runDirect("ROLLBACK");
	}

	function			hasExplicitSerial()
	{
		return null;
	}

	function			addOffsetLimit(&$statement, &$binds, $offset, $limit)
	{
		$statement .= " LIMIT ?,?";
		array_push($binds, $offset, $limit);
	}

	function			addOffsetLimitRef(&$statement, &$refBinds, $offset, $limit)
	{
		$statement .= " LIMIT ?,?";
		array_push($refBinds, $offset, $limit);
	}

	function			needDeleteAliasFrom()
	{
		return 0;
	}

	function			escapeString($str)
	{
		return \pg_escape_string($this->pg_handle, $str);
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
		$q_cnt = 0;
		for ($st = 0;;) {
			if (($q = strpos($statement, '?', $st)) !== false) {
				if (($a = strpos($statement, '\'', $st)) === false || $a > $q) {
					$i = ++$q_cnt;
					$statement = substr($statement, 0, $q)."\$$i".substr($statement, $q+1);
					$st = $q+2;
				}
				else {
					for ($st = $a+1; ; ) {
						if (($a = strpos($statement, '\'', $st)) === false)
							throw new \net\dryuf\core\Exception("unclosed string");
						if (($b = strpos($statement, '\\', $st)) !== false && $b < $a) {
							$st = $b+2;
						}
						else {
							$st = $a+1;
							break;
						}
					}
				}
			}
			else {
				break;
			}
		}
		$ident = $this->allocateIdent();
		try {
			if (!($stmt = \pg_prepare($this->pg_handle, $ident, $statement))) {
				throw new \net\dryuf\sql\SqlParseException($statement, -1, \pg_last_error_code($this->pg_handle), \pg_last_error($this->pg_handle));
			}
			return new \net\dryuf\sql\pgsql\PgsqlStatement($this, $ident, $stmt);
		}
		catch (\net\dryuf\core\Exception $ex) {
			$this->freeIdent($ident);
			throw $ex;
		}
	}

	function			runDirect($statement)
	{
		if (!\pg_query($this->pg_handle, $statement)) {
			throw new \net\dryuf\sql\SqlException(-1, \pg_last_error($this->pg_handle), \pg_last_error_code($this->pg_handle));
		}
	}

	function			ping()
	{
		if (!\pg_ping($this->pg_handle))
			throw new \net\dryuf\sql\SqlException(-1, \pg_last_error($this->pg_handle), \pg_last_error_code($this->pg_handle));
	}

	function			allocateIdent()
	{
		if (count($this->free_idents) > 0)
			return array_pop($this->free_idents);
		return strval($this->cur_ident++);
	}

	function			freeIdent($ident)
	{
		array_push($this->free_idents, $ident);
	}

	public				$pg_handle;

	public				$cur_ident = 0;
	public				$free_idents = array();
};


?>
