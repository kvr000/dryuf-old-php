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


class CsvdbKeyValueDb implements \net\dryuf\keydb\KeyValueDb
{
	function			__construct()
	{
	}

	static function			open($filename)
	{
		$db = new self();
		$db->readImplementation($filename);
		return $db;
	}

	function			readImplementation($filename)
	{
		$fd = fopen("$filename.csvdb", "r");
		while (($list = fgetcsv($fd)) !== false) {
			$this->value_hash[$list[0]] = $list[1];
		}
		fclose($fd);
	}

	function			findOrDefault($key, $default)
	{
		return isset($this->value_hash[$key]) ? $this->value_hash[$key] : null;
	}

	function			listPrefixedStrip($prefix)
	{
		$map = new \net\dryuf\util\php\StringNativeHashMap();
		foreach ($this->value_hash as $key => $val) {
			if (strpos($key, $prefix) == 0)
				$map->put(substr($key, strlen($prefix)), $val);
		}
		return $map;
	}

	public				$value_hash = array();
}


?>
