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

namespace net\dryuf\keydb;


class DbaKeyValueDb implements \net\dryuf\keydb\KeyValueDb
{
	function			__construct()
	{
	}

	static function			open($filename)
	{
		$db = new self();
		if (!function_exists('dba_open'))
			throw new \net\dryuf\core\Exception("dba_open is not supported");
		$db->db = dba_open("$filename.db", "r", "db4");
		if (!$db->db) {
			throw new \net\dryuf\core\Exception("no database: $filename");
		}
		return $db;
	}

	function			findOrDefault($key, $default)
	{
		$text = @dba_fetch($key, $this->db);
		if ($text === false) {
			#echo "key '$key' not found\n";
			$text = $default;
		}
		return $text;
	}

	function			listPrefixedStrip($prefix)
	{
		$map = \net\dryuf\core\php\StringNativeHashMap();
		for ($key = dba_firstkey($this->db); $key !== false; $key = dba_nextkey($this->db)) {
			if (strpos($key, $prefix) == 0)
				$map->put(substr($key, strlen($prefix)), dba_fetch($key, $this->db));
		}
		return $map;
	}

	protected			$db;
}


?>
