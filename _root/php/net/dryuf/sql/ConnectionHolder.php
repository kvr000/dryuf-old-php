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

namespace net\dryuf\sql;


class ConnectionHolder implements \net\dryuf\sql\Connection
{
	function			__construct($targetConnection, $useCache)
	{
		$this->targetConnection = $targetConnection;
	}

	function			close()
	{
		return $this->targetConnection->close();
	}

	function			getDialect()
	{
		return $this->targetConnection->getDialect();
	}

	function			getDriver()
	{
		return $this->targetConnection->getDriver();
	}

	function			ping()
	{
		$this->targetConnection->ping();
	}

	function			setAutoCommit($enable)
	{
		$this->targetConnection->setAutoCommit($enable);
	}

	function			commit()
	{
		$this->targetConnection->commit();
	}

	function			rollback()
	{
		$this->targetConnection->rollback();
	}

	function			hasExplicitSerial()
	{
		return $this->targetConnection->hasExplicitSerial();
	}

	function			addOffsetLimit(&$statement, &$binds, $offset, $limit)
	{
		$this->targetConnection->addOffsetLimit($statement, $binds, $offset, $limit);
	}

	function			addOffsetLimitRef(&$statement, &$refBinds, $offset, $limit)
	{
		$this->targetConnection->addOffsetLimitRef($statement, $refBinds, $offset, $limit);
	}

	function			needDeleteAliasFrom()
	{
		return $this->targetConnection->needDeleteAliasFrom();
	}

	function			prepareStatement($statement)
	{
		if ($this->useCache > 0)
			return $this->cacheStatement($statement, function () use ($statement) { return $this->targetConnection->prepareStatement($statement); });
		return $this->targetConnection->prepareStatement($statement);
	}

	function			runDirect($statement)
	{
		$this->targetConnection->runDirect($statement);
	}

	function			escapeString($str)
	{
		return $this->targetConnection->escapeString($str);
	}

	function			conversionFrom($type, $expr)
	{
		return $this->targetConnection->conversionFrom($type, $expr);
	}

	function			conversionTo($type, $expr)
	{
		return $this->targetConnection->conversionTo($type, $expr);
	}

	function			cacheStatement($name, $creator)
	{
		if ($this->useCache >= 0 && isset($this->cachedStatements[$name]))
			return $this->cachedStatements[$name];
		return $this->cachedStatements[$name] = call_user_func($creator, $this);
	}

	protected			$targetConnection;
	protected			$cachedStatements;
	protected			$useCache = 0;
}


?>
