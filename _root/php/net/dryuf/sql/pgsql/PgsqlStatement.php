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


class PgsqlStatement implements \net\dryuf\sql\Statement
{
	function			__construct($connection, $ident, $statement)
	{
		$this->connection = $connection;
		$this->ident = $ident;
		$this->statement = $statement;
	}

	function			__destruct()
	{
		$this->connection->freeIdent($this->ident);
		$this->connection->runDirect("DEALLOCATE \"$this->ident\"");
	}

	function			bindParams($binds)
	{
		if (!is_array($binds)) {
			throw new \net\dryuf\core\Exception("expects binds to be an array");
		}
		$this->binds = $binds;
		return $this;
	}

	function			executeQuery()
	{
		if (!($result = pg_execute($this->connection->pg_handle, $this->ident, isset($this->binds) ? $this->binds : array())))
			$this->throwException();
		return new \net\dryuf\sql\pgsql\PgsqlResultSet($this, $result);
	}

	function			executeUpdate()
	{
		if (!pg_execute($this->connection->pg_handle, $this->ident, $this->binds))
			$this->throwException();
		return pg_affected_rows($this->connection->pg_handle);
	}

	function			getInsertId()
	{
		throw new \net\dryuf\core\UnimplementedException();
		if (($id = mysqli_stmt_insert_id($this->statement)) == 0) {
			$this->throwException();
		}
		return $id;
	}

	function			throwException()
	{
		$err = pg_last_error($this->connection->pg_handle);
		if (0 && $state == 23000) {
			$desc = mysqli_stmt_error($this->statement);
			$contraint = "";
			if (preg_match("/\'([^\']*)\'[^\']*$/", $desc, $match))
				$constraint = $match[1];
			throw new \net\dryuf\sql\SqlUniqueConstraintException($state, \pg_last_error_code($this->connection->pg_handle), $desc, $constraint);
		}
		throw new \net\dryuf\sql\SqlException("unknown", \pg_last_error_code($this->connection->pg_handle), $err);
	}

	public				$connection;
	public				$ident;
	public				$statement;

	public				$binds;
};


?>
