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

namespace net\dryuf\dao\phpjpa;


class PersistenceList extends \net\dryuf\util\AbstractList implements \net\dryuf\util\Set
{
	public function			__construct($entitiesContext, \net\dryuf\dao\phpjpa\JpaMetaField $fieldMeta, $ownerMeta, $ownerPk)
	{
		parent::__construct();

		$this->entitiesContext = $entitiesContext;
		$this->fieldMeta = $fieldMeta;
		$this->ownerMeta = $ownerMeta;
		$this->ownerPk = $ownerPk;
	}

	public function			add($obj)
	{
		$this->initPersistence();
		array_push($this->storage, $obj);
		$this->entitiesContext->persist($obj);
	}

	public function			addFirst($obj)
	{
		$this->initPersistence();
		array_unshift($this->storage, $obj);
		$this->entitiesContext->persist($obj);
	}

	public function			addIndexed($index, $obj)
	{
		$this->initPersistence();
		array_splice($this->storage, $index, 0, array($obj));
		$this->entitiesContext->persist($obj);
	}

	public function			addAll($collection)
	{
		$this->addAllIndexed($this->size(), $collection);
	}

	public function			addAllIndexed($index, $collection)
	{
		$this->initPersistence();
		array_splice($this->storage, $index, 0, $collection->toArray());
		foreach ($collection as $obj)
			$this->entitiesContext->persist($obj);
	}

	public function			clear()
	{
		$this->initPersistence();
		foreach ($this->storage as $obj)
			$this->entitiesContext->remove($obj);
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
		$this->initPersistence();
		return $this === $compared;
	}

	public function			get($index)
	{
		$this->initPersistence();
		return $this->storage[$index];
	}

	public function			hashCode()
	{
		$this->initPersistence();
		return \net\dryuf\core\Dryuf::getInternalObjectHash($this);
	}

	public function			indexOf($obj)
	{
		$this->initPersistence();
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
		$this->initPersistence();
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
		$this->initPersistence();
		return count($this->storage) != 0 ? $this->storage[0] : null;
	}

	public function			pop()
	{
		$this->initPersistence();
		return $this->removeIndexed(0);
	}

	public function			push($obj)
	{
		$this->addFirst($obj);
	}

	public function			remove($obj)
	{
		$this->initPersistence();
		$i = 0;
		for ($it = $this->iterator(); $it->hasNext(); ++$i) {
			$o = $it->next();
			if (\net\dryuf\core\Dryuf::equalObjects($obj, $o)) {
				$it->removeIndexed($i);
				return true;
			}
		}
		$this->entitiesContext->remove($obj);
		return false;
	}
	
	public function			removeIndexed($idx)
	{
		$this->initPersistence();
		if (count($this->storage) <= $idx)
			throw new \RuntimeException("index out of bounds: $idx");
		$this->entitiesContext->remove($this->storage[$idx]);
		$ret = array_splice($this->storage, $idx, 1);
		return $ret[0];
	}

	public function			removeAll($collection)
	{
		$this->initPersistence();
		$ret = false;
		for ($it = $collection->iterator(); $it->hasNext(); ) {
			if ($this->remove($it->next()))
				$ret = true;
		}
		return $ret;
	}

	public function			retainAll($collection)
	{
		$this->initPersistence();
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
		throw new \RuntimeException("TODO");
		$this->initPersistence();
		$this->storage[$index] = $obj;
	}

	public function			size()
	{
		$this->initPersistence();
		return count($this->storage);
	}

	public function			subList($fromIndex, $toIndex)
	{
		$this->initPersistence();
		$result = new \net\dryuf\util\LinkedList();
		$i = $fromIndex;
		for ($it = $this->listIterator($fromIndex); $i < $toIndex && $it->hasNext(); ++$i) {
			$result->add($it->next());
		}
		return $result;
	}

	public function			toArray()
	{
		$this->initPersistence();
		return $this->storage;
	}

	public function			initPersistence()
	{
		$this->storage = $this->entitiesContext->readOneToMany($this->fieldMeta, $this->ownerMeta, $this->ownerPk)->toArray();
	}

	/* php iterator interface */
	public function			getIterator()
	{
		return new \net\dryuf\util\AbstractListPhpIterator($this, 0);
	}

	public function			createSameEmpty()
	{
		return new \net\dryuf\util\LinkedList();
	}

	protected			$entitiesContext;

	protected			$fieldMeta;

	protected			$ownerMeta;

	protected			$ownerPk;
}


?>
