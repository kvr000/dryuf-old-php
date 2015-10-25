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

namespace net\dryuf\logging;


class DirLogger extends \net\dryuf\logging\TextLogger
{
	function			__construct($dirname)
	{
		parent::__construct();
		try {
			if (!($d = opendir($dirname)))
				throw new \net\dryuf\core\Exception("failed to open $dirname");
			closedir($d);
		}
		catch (\net\dryuf\core\Exception $ex) {
			if (!mkdir($dirname, 0777))
				throw $ex;
		}
		$this->dirname = $dirname;
		$this->dayname = "";
	}

	function			appendMessage($level, $msg)
	{
		$t = time(NULL);
		$fn = gmdate('ymd', $t);
		$ft = gmdate('Y-m-d H:i:s', $t);
		if ($fn != $this->dayname) {
			$this->fd = fopen("$this->dirname/$fn.log", "a");
			$this->dayname = $fn;
		}
		fprintf($this->fd, "[%s] %d %s: %s\n", $ft, 0, $level, $msg);
	}

	function			appendDump($level, $data)
	{
		if ($this->fd)
			fprintf($this->fd, "\t%s\n", $data);
	}

	public				$dayname;

	public				$fd;
};


?>
