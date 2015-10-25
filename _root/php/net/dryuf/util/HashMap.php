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

namespace net\dryuf\util;


class HashMap extends \net\dryuf\util\AbstractMap
{
	function			__construct($initMap = null)
	{
		$this->hashes = array();
		if ($initMap instanceof \net\dryuf\util\Map)
			$this->putAll($initMap);
	}

	public function			clear()
	{
		array_splice($this->hashes, 0, count($this->hashes));
	}

	public function			containsKey($key)
	{
		$hash = \net\dryuf\core\Dryuf::hashCodeObject($key);
		if (!isset($this->hashes[$hash]))
			return false;
		foreach ($this->hashes[$hash] as $mapEntry) {
			if (\net\dryuf\core\Dryuf::equalObjects($key, $mapEntry->getKey()))
				return true;
		}
		return false;
	}

	public function			containsValue($value)
	{
		foreach ($this->hashes as $list) {
			foreach ($list as $mapEntry) {
				if (\net\dryuf\core\Dryuf::equalObjects($key, $mapEntry->getKey()))
					return true;
			}
		}
		return false;
	}

	public function			entrySet()
	{
		$collection = new LinkedList();
		foreach ($this->hashes as $list) {
			foreach ($list as $mapEntry) {
				$collection->add($mapEntry);
			}
		}
		return $collection;
	}

	public function			get($key)
	{
		assert(!is_null($key));
		$hash = \net\dryuf\core\Dryuf::hashCodeObject($key);
		if (!isset($this->hashes[$hash]))
			return null;
		foreach ($this->hashes[$hash] as $mapEntry) {
			if ($mapEntry->getHash() == $hash && \net\dryuf\core\Dryuf::equalObjects($key, $mapEntry->getKey()))
				return $mapEntry->getValue();
		}
		return null;
	}

	public function			put($key, $value)
	{
		assert(!is_null($key));
		$hash = \net\dryuf\core\Dryuf::hashCodeObject($key);
		if (!isset($this->hashes[$hash])) {
			$this->hashes[$hash] = array();
		}
		foreach ($this->hashes[$hash] as $mapEntry) {
			if (\net\dryuf\core\Dryuf::equalObjects($key, $mapEntry->getKey())) {
				$mapEntry->setValue($value);
				return;
			}
		}
		array_push($this->hashes[$hash], new \net\dryuf\util\AbstractMapEntry($key, $value, $hash, null));
	}

	public function			remove($key)
	{
		assert(!is_null($key));
		$hash = \net\dryuf\core\Dryuf::hashCodeObject($key);
		if (!isset($this->hashes[$hash])) {
			return;
		}
		$i = 0;
		foreach ($this->hashes[$hash] as $mapEntry) {
			if ($mapEntry->getHash() == $hash && \net\dryuf\core\Dryuf::equalObjects($key, $mapEntry->getKey())) {
				array_splice($this->hashes[$hash], $i, 1);
				return;
			}
			$i++;
		}
	}

	public function			size()
	{
		$size = 0;
		foreach ($this->hashes as $list) {
			$size += count($list);
		}
		return $size;
	}

	public function			createSameEmpty()
	{
		return new self();
	}

	protected			$hashes;
}


?>
