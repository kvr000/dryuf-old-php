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


class LinkedHashMap extends \net\dryuf\util\HashMap
{
	function			__construct()
	{
		parent::__construct();
	}

	public function			entrySet()
	{
		$l = array();
		foreach ($this->hashes as $list) {
			foreach ($list as $mapEntry) {
				array_push($l, $mapEntry);
			}
		}
		usort($l, function ($a, $b) { return \net\dryuf\core\Dryuf::compareObjects($a->getSequence(), $b->getSequence()); });
		return LinkedList::createFromArray($l);
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
		array_push($this->hashes[$hash], new \net\dryuf\util\AbstractMapEntry($key, $value, $hash, ++$this->sequence));
	}

	public function			createSameEmpty()
	{
		return new self();
	}

	protected			$sequence = 0;
}


?>
