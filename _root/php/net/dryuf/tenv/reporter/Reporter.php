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

namespace net\dryuf\tenv\reporter;


interface Reporter
{
	public function			reportAllStart($classCount, $totalCount);

	public function			reportAllEnd($classCount, $classFailed, $totalCount, $totalFailed);

	public function			reportClassCreateFailure($testClass, $totalIndex, $ex);

	public function			reportClassStart($testObject, $count);

	public function			reportClassEnd($testObject, $count, $failed, $millitime);

	public function			reportMethodStart($testObject, $method, $index, $totalIndex);

	public function			reportMethodEnd($testObject, $method, $index, $totalIndex, $error, $millitime);

	public function			reportSuccess($testObject, $method, $index, $totalIndex);

	public function			reportUnthrown($testObject, $method, $index, $totalIndex, $expectedException);

	public function			reportException($testObject, $method, $index, $totalIndex, $ex);
}


?>
