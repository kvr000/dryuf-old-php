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


interface Listable extends \net\dryuf\util\Collection
{
	public function			add($obj);

	public function			addIndexed($index, $obj);

	public function			addAll($collection);

	public function			addAllIndexed($index, $collection);

	public function			clear();

	public function			contains($obj);

	public function			containsAll($collection);

	public function			equals($compared);

	public function			get($index);

	public function			hashCode();

	public function			indexOf($obj);

	public function			isEmpty();

	public function			iterator();

	public function			lastIndexOf($obj);

	public function			listIterator($index = 0);

	public function			remove($obj);
	
	public function			removeIndexed($index);

	public function			removeAll($collection);
	
	public function			retainAll($collection);
	
	public function			set($index, $obj);
	
	public function			size();
	
	public function			subList($fromIndex, $toIndex);
	
	public function			toArray();
}

interface ListIterator extends Iterator
{
	public function			add($obj);

	public function			hasNext();

	public function			hasPrevious();

	public function			next();

	public function			nextIndex();

	public function			previous();

	public function			previousIndex();

	public function			remove();

	public function			set($obj);
}


?>
