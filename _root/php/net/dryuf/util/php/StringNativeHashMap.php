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


/**
 * We need the special class because of php black magic which on its own converts the keys to integer.
 *
 * The class enforces the keys returned to be always strings.
 */
class StringNativeHashMap extends \net\dryuf\util\php\NativeHashMap
{
	public static function		createFromNativeArray($arr)
	{
		$self = new self();
		$self->map = $arr;
		return $self;
	}

	function			__construct($initMap = null)
	{
		parent::__construct($initMap);
	}

	public function			entrySet()
	{
		$collection = new \net\dryuf\util\LinkedList();
		foreach ($this->map as $key => $value) {
			$collection->add(new \net\dryuf\util\AbstractMapEntry(strval($key), $value, null, null));
		}
		return $collection;
	}

	public function			createSameEmpty()
	{
		return new self();
	}
}


?>
