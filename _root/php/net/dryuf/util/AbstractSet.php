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


abstract class AbstractSet extends \net\dryuf\core\Object implements \net\dryuf\util\Set
{
	public function			__construct()
	{
	}

	public function			add($obj)
	{
		if ($this->backing->containsKey($obj))
			return false;
		$this->backing->put($obj, null);
		return true;
	}

	public function			addIndexed($index, $obj)
	{
		return $this->add($obj);
	}

	public function			addAll($collection)
	{
		foreach ($collection as $obj) {
			$this->backing->put($obj, null);
		}
	}

	public function			addAllIndexed($index, $collection)
	{
		return $this->addAll($collection);
	}

	public function			clear()
	{
		$this->backing->clear();
	}

	public function			contains($o)
	{
		return $this->backing->containsKey($o);
	}

	public function			containsAll($collection)
	{
		for ($it = $collection->iterator(); $it->hasNext(); ) {
			if (!$this->contains($it->next()))
				return false;
		}
		return true;
	}

	public function			isEmpty()
	{
		return $this->backing->isEmpty();
	}

	public function			iterator()
	{
		throw new \RuntimeException("TODO");
	}

	public function			remove($o)
	{
		return $this->backing->remove($o);
	}

	public function			removeIndexed($idx)
	{
		return $this->backing->remove($o);
	}

	public function			removeAll($collection)
	{
		$ret = false;
		for ($it = $collection->iterator(); $it->hasNext(); ) {
			if ($this->remove($it->next()))
				$ret = true;
		}
		return $ret;
	}

	public function			retainAll($collection)
	{
		$ret = false;
		for ($it = $this->iterator(); $it->hasNext(); ) {
			if (!$collection->contains($it->next())) {
				$it->remove();
				$ret = true;
			}
		}
		return $ret;
	}

	public function			size()
	{
		return $this->backing->size();
	}

	public function			toArray()
	{
		return $this->backing->keySet()->toArray();
	}

	public function			getIterator()
	{
		return new AbstractSetPhpIterator($this);
	}

	public function			getBacking()
	{
		return $this->backing;
	}

	protected			$backing;
}


class AbstractSetIterator extends \net\dryuf\core\Object implements \net\dryuf\util\Iterator
{
	public function			__construct(\net\dryuf\util\AbstractSet $owner)
	{
		$this->owner = $owner;
		$this->keys = $this->owner->getBacking()->keys();
		$this->keysIterator = $this->keys->iterator();
	}

	public function			hasNext()
	{
		return $this->keysIterator->hasNext();
	}

	public function			next()
	{
		return ($this->currentKey = $this->keysIterator->next());
	}

	public function			remove()
	{
		$this->owner->getBacking()->remove($this->currentKey);
		$this->keysIterator->remove();
	}

	protected			$owner;
	protected			$keys;
	protected			$keysIterator;
	protected			$currentKey;
}


class AbstractSetPhpIterator implements \Iterator
{
	public function			__construct(\net\dryuf\util\AbstractSet $owner)
	{
		$this->owner = $owner;
		$this->keys = $this->owner->getBacking()->keySet();
		$this->keysPhpIterator = $this->keys->getIterator();
	}

	public function			current()
	{
		return $this->keysPhpIterator->current();
	}

	public function			key()
	{
		return $this->keysPhpIterator->key();
	}

	public function			next()
	{
		return $this->keysPhpIterator->next();
	}

	public function			rewind()
	{
		return $this->keysPhpIterator->rewind();
	}

	public function			valid()
	{
		return $this->keysPhpIterator->valid();
	}

	protected			$owner;
	protected			$keys;
	protected			$keysPhpIterator;
}


?>
