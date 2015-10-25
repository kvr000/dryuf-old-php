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

namespace net\dryuf\util\php;


class NativeHashMap extends \net\dryuf\util\AbstractMap
{
	public static function		createFromNativeArray($arr)
	{
		$self = new self();
		$self->map = $arr;
		return $self;
	}

	function			__construct($initMap = null)
	{
		$this->map = array();
		if ($initMap instanceof \net\dryuf\util\Map)
			$this->putAll($initMap);
	}

	public function			clear()
	{
		array_splice($this->map, 0, count($this->map));
	}

	public function			containsKey($key)
	{
		return array_key_exists($key, $this->map);
	}

	public function			containsValue($value)
	{
		foreach ($this->map as $mapEntry) {
			if (\net\dryuf\core\Dryuf::equalObjects($mapEntry->getValue(),  $value))
				return true;
		}
		return false;
	}

	public function			entrySet()
	{
		$collection = new \net\dryuf\util\LinkedList();
		foreach ($this->map as $key => $value) {
			$collection->add(new \net\dryuf\util\AbstractMapEntry($key, $value, null, null));
		}
		return $collection;
	}

	public function			get($key)
	{
		return isset($this->map[$key]) ? $this->map[$key] : null;
	}

	public function			put($key, $value)
	{
		$this->map[$key] = $value;
	}

	public function			remove($key)
	{
		unset($this->map[$key]);
	}

	public function			size()
	{
		return count($this->map);
	}

	public function			createSameEmpty()
	{
		return new self();
	}

	protected			$map;

	protected			$sequence;
}


?>
