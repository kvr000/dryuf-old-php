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


abstract class AbstractList extends \net\dryuf\core\Object implements \net\dryuf\util\Listable
{
	public function			__construct($arg = null)
	{
		parent::__construct();
		if (!is_null($arg)) {
			foreach ($arg as $obj)
				$this->add($obj);
		}
	}

	public function			add($obj)
	{
		array_push($this->storage, $obj);
	}

	public function			addFirst($obj)
	{
		array_unshift($this->storage, $obj);
	}

	public function			addIndexed($index, $obj)
	{
		array_splice($this->storage, $index, 0, array($obj));
	}

	public function			addAll($collection)
	{
		$this->addAllIndexed($this->size(), $collection);
	}

	public function			addAllIndexed($index, $collection)
	{
		array_splice($this->storage, $index, 0, $collection->toArray());
	}

	public function			clear()
	{
		array_slice($this->storage, 0, count($this->storage));
	}

	public function			contains($obj)
	{
		return $this->indexOf($obj) >= 0;
	}

	public function			containsAll($collection)
	{
		for ($it = $collection->iterator(); $it->hasNext(); ) {
			if (!$this->contains($it->next()))
				return false;
		}
		return true;
	}

	public function			equals($compared)
	{
		return $this === $compared;
	}

	public function			get($index)
	{
		return $this->storage[$index];
	}

	public function			hashCode()
	{
		return \net\dryuf\core\Dryuf::getInternalObjectHash($this);
	}

	public function			indexOf($obj)
	{
		$i = 0;
		for ($it = $this->iterator(); $it->hasNext(); ++$i) {
			$o = $it->next();
			if (\net\dryuf\core\Dryuf::equalObjects($obj, $o))
				return $i;
		}
		return -1;
	}

	public function			isEmpty()
	{
		return $this->size() == 0;
	}

	public function			iterator()
	{
		return new \net\dryuf\util\AbstractListIterator($this, 0);
	}

	public function			lastIndexOf($obj)
	{
		$i = $this->size()-1;
		for ($it = $this->listIterator($this->size()); $it->hasPrevious(); --$i) {
			$o = $it->previous();
			if (\net\dryuf\core\Dryuf::equalObjects($obj, $o))
				return $i;
		}
		return -1;
	}

	public function			listIterator($index = 0)
	{
		return new \net\dryuf\util\AbstractListIterator($this, $index);
	}

	public function			peek()
	{
		return count($this->storage) != 0 ? $this->storage[0] : null;
	}

	public function			pop()
	{
		return $this->removeIndexed(0);
	}

	public function			push($obj)
	{
		$this->addFirst($obj);
	}

	public function			remove($obj)
	{
		$i = 0;
		for ($it = $this->iterator(); $it->hasNext(); ++$i) {
			$o = $it->next();
			if (\net\dryuf\core\Dryuf::equalObjects($obj, $o)) {
				$it->removeIndexed($i);
				return true;
			}
		}
		return false;
	}
	
	public function			removeIndexed($idx)
	{
		if (count($this->storage) <= $idx)
			throw new \RuntimeException("index out of bounds: $idx");
		$ret = array_splice($this->storage, $idx, 1);
		return $ret[0];
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

	public function			set($index, $obj)
	{
		$this->storage[$index] = $obj;
	}

	public function			size()
	{
		return count($this->storage);
	}

	public function			subList($fromIndex, $toIndex)
	{
		$result = new \net\dryuf\util\LinkedList();
		$i = $fromIndex;
		for ($it = $this->listIterator($fromIndex); $i < $toIndex && $it->hasNext(); ++$i) {
			$result->add($it->next());
		}
		return $result;
	}

	public function			toArray()
	{
		return $this->storage;
	}

	/* php iterator interface */
	public function			getIterator()
	{
		return new AbstractListPhpIterator($this, 0);
	}

	protected function		initFromArray($l)
	{
		$this->storage = $l;
	}

	protected			$storage = array();
}

class AbstractListIterator extends \net\dryuf\core\Object implements \net\dryuf\util\ListIterator
{
	public function			__construct(\net\dryuf\util\AbstractList $owner, $position)
	{
		$this->owner = $owner;
		$this->position = $position;
	}

	public function			add($obj)
	{
		$this->owner->addIndexed($this->position++, $obj);
	}

	public function			hasNext()
	{
		return $this->position < $this->owner->size();
	}

	public function			hasPrevious()
	{
		return $this->position > 0;
	}

	public function			next()
	{
		return $this->owner->get($this->position++);
	}

	public function			nextIndex()
	{
		return $this->position;
	}

	public function			previous()
	{
		return $this->owner->get(--$this->position);
	}

	public function			previousIndex()
	{
		return $this->position-1;
	}

	public function			remove()
	{
		$this->owner->removeIndexed($this->position--);
	}

	public function			set($obj)
	{
		$this->owner->set($this->position, $obj);
	}

	protected			$owner;
	protected			$position;
}


class AbstractListPhpIterator implements \Iterator
{
	public function			__construct(\net\dryuf\util\AbstractList $owner, $position)
	{
		$this->owner = $owner;
		$this->position = $position;
	}

	public function			current()
	{
		return $this->owner->get($this->position);
	}

	public function			key()
	{
		return $this->position;
	}

	public function			next()
	{
		++$this->position;
	}

	public function			rewind()
	{
		$this->position = 0;
	}

	public function			valid()
	{
		return $this->position < $this->owner->size();
	}

	protected			$owner;
	protected			$position;
}


?>
