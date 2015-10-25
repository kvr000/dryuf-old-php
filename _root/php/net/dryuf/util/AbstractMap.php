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


abstract class AbstractMap extends \net\dryuf\core\Object implements \net\dryuf\util\Map
{
	public function			getOrDefault($key, $defaultValue)
	{
		if (is_null($value = $this->get($key)) && !$this->containsKey($key))
			$value = $defaultValue;
		return $value;
	}

	public function			forEachDo($func)
	{
		foreach ($this->entrySet() as $entry) {
			$func($entry->getKey(), $entry->getValue());
		}
	}

	public function			isEmpty()
	{
		return $this->size() == 0;
	}

	public function			keySet()
	{
		$keys = new \net\dryuf\util\ArrayList();
		for ($it = $this->entrySet()->iterator(); $it->hasNext(); )
			$keys->add($it->next()->getKey());
		return $keys;
	}

	public function			putAll($map)
	{
		for ($it = $map->entrySet(); $it->hasNext(); ) {
			$entry = $it->next();
			$keys->put($entry->getKey(), $entry->getValue());
		}
	}

	public function			putIfAbsent($key, $value)
	{
		if (!$this->containsKey($key))
			$this->put($key, $value);
	}

	public function			replace($key, $value)
	{
		if ($this->containsKey($key))
			$this->put($key, $value);
	}

	public function			values()
	{
		$keys = new \net\dryuf\util\ArrayList();
		for ($it = $this->entrySet()->iterator(); $it->hasNext(); )
			$keys->add($it->next()->getValue());
		return $keys;
	}

	public function			compute($key, $computer)
	{
		$value = $computer($key, $this->get($key));
		$this->put($key, $value);
		return $value;
	}

	public function			computeIfAbsent($key, $computer)
	{
		if (is_null($value = $this->get($key)) /* && !$this->containsKey($key)*/) {
			if (!is_null($value = $computer($key)))
				$this->put($key, $value);
		}
		return $value;
	}

	public function			computeIfPresent($key, $computer)
	{
		if (is_null($value = $this->get($key)) /* && !$this->containsKey($key)*/) {
			if (!is_null($value = $computer($key))) {
				$this->put($key, $value);
			}
			else {
				$this->remove($key);
			}
		}
		return $value;
	}

	public function			merge($key, $value, $merger)
	{
		if (is_null($orig = $this->get($key)) && !$this->containsKey($key)) {
			$this->put($key, $value);
		}
		else {
			$this->put($key, $value = $computer($orig, $value));
		}
		return $value;
	}
}


class AbstractMapEntry extends \net\dryuf\core\Object implements \net\dryuf\util\Map\Entry
{
	public function			__construct($key, $value, $hash, $sequence)
	{
		$this->key = $key;
		$this->value = $value;
		$this->hash = $hash;
		$this->sequence = $sequence;
	}

	public function			getKey()
	{
		return $this->key;
	}

	public function			getValue()
	{
		return $this->value;
	}

	public function			setValue($value)
	{
		$this->value = $value;
	}

	public function			getSequence()
	{
		return $this->sequence;
	}

	public function			getHash()
	{
		return $this->hash;
	}

	protected			$key;
	protected			$value;
	protected			$hash;
	protected			$sequence;
}


?>
