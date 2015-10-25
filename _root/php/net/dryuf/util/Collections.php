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


class Collections extends \net\dryuf\core\Object
{
	public static function		resetListItemsFromArray(\net\dryuf\util\Listable $list, $array)
	{
		for ($i = count($array); --$i >= 0; ) {
			$list->set($i, $array[$i]);
		}
	}

	public static function		sort(\net\dryuf\util\Listable $list, $comparator = null)
	{
		$arr = $list->toArray();
		usort($arr, !is_null($comparator) ? $comparator : function ($a, $b) { return \net\dryuf\core\Dryuf::compareObjects($a, $b); });
		self::resetListItemsFromArray($list, $arr);
	}

	public static function		reverse(\net\dryuf\util\Listable $list)
	{
		self::resetListItemsFromArray($list, array_reverse($list->toArray()));
	}

	public static function		singleton($item)
	{
		return \net\dryuf\util\HashSet::createFromArray(array($item));
	}

	public static function		singletonList($item)
	{
		return \net\dryuf\util\LinkedList::createFromArray(array($item));
	}

	public static function		filter(\net\dryuf\util\Collection $input, $filter)
	{
		$output = new \net\dryuf\util\LinkedList();
		foreach ($input as $item) {
			if ($filter($item))
				$output->add($item);
		}
		return $output;
	}

	public static function		transform(\net\dryuf\util\Collection $input, $processor)
	{
		$output = new \net\dryuf\util\LinkedList();
		foreach ($input as $item) {
			$output->add($processor($item));
		}
		return $output;
	}
}


?>
