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


interface Map
{
	public function			clear();

	public function			containsKey($key);

	public function			containsValue($value);

	public function			compute($key, $computer);

	public function			computeIfAbsent($key, $computer);

	public function			computeIfPresent($key, $computer);

	public function			entrySet();

	public function			equals($compared);

	public function			forEachDo($consumer);

	public function			get($key);

	public function			getOrDefault($key, $defaultValue);

	public function			hashCode();

	public function			isEmpty();

	public function			keySet();

	public function			merge($key, $value, $merger);

	public function			put($key, $value);

	public function			putAll($map);

	public function			putIfAbsent($key, $value);

	public function			remove($key);

	public function			replace($key, $value);

	public function			size();

	public function			values();
}


?>
