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


class ConnectionManager implements \javax\sql\DataSource
{
	static function			openStaticConnection($connectUrl)
	{
		$self = new self();
		$self->connectUrl = $connectUrl;
		return $self->getConnection();
	}

	function			getConnection()
	{
		if (is_null($connection = array_pop($this->pool))) {
			if (!preg_match('/;driver=([A-Za-z0-9\\\\:._]+);/', ";$this->connectUrl;", $regs))
				throw new \net\dryuf\sql\SqlException(-1, -1, "driver not specified in connect URL");
			$driver = $regs[1];
			if (preg_match('/(::|\\\\)([a-z0-9]+)$/', $driver, $regs))
				$driver .= "\\".\ucfirst($regs[2])."Connection";
			$connection = new \net\dryuf\sql\ConnectionManagerConnection($this, \net\dryuf\core\Dryuf::callClassStatic($driver, "openNew", array($this->connectUrl)));
		}
		$connection->setManager($this);
		return $connection;
	}

	function			releaseConnection($connection)
	{
		$connection->rollback();
		array_push($this->pool, $connection);
	}

	function			getUseCache()
	{
		return $this->useCache;
	}

	protected			$connectUrl;

	protected			$pool = array();

	protected			$useCache = 1;
}


?>
