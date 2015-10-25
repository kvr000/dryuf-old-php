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

namespace net\dryuf\core;


class SuppressError
{
	public function			__construct()
	{
		$this->old_handler = set_error_handler(array('net\dryuf\core\SuppressError', "noneErrorHandler"));
	}

	public static function		noneErrorHandler()
	{
	}

	public function			__destruct()
	{
		set_error_handler($this->old_handler);
	}

	public static function		runSuppressed($func)
	{
		$suppress = new self();
		$ret = call_user_func($func);
		unset($suppress);
		return $ret;
	}

	public static function		requireSuppressed($file)
	{
		$suppress = new self();
		require_once $file;
		unset($suppress);
	}

	public				$old_handler;
}


?>
