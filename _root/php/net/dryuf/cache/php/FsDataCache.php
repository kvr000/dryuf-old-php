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

namespace net\dryuf\cache\php;


class FsDataCache implements \net\dryuf\core\DataCache
{
	public function			__construct()
	{
		if (substr($this->root = \net\dryuf\core\Dryuf::$workRoot, -1) != "/")
			throw new \net\dryuf\core\RuntimeException("root does not end with '/'");
		$this->root .= "_rtcache/";
		\net\dryuf\io\DirUtil::mkpath($this->root, 0777);
		if (rand(0, isset(\net\dryuf\core\Dryuf::$config['net.dryuf.cache.php.FsDataCache.cleanupFrequency']) ? \net\dryuf\core\Dryuf::$config['net.dryuf.cache.php.FsDataCache.cleanupFrequency'] : 1000) == 0) {
			$till = time()-3600;
			foreach (scandir($this->root) as $fname) {
				try {
					$full = $this->root.$fname;
					if (filemtime($full) <= $till)
						unlink($full);
				}
				catch (\Exception $ex) {
				}
			}
		}
	}

	public function			get($owner, $driver, $key)
	{
		$full = "$owner\x00$driver\x00$key";
		if (strlen($full) >= 550)
			return null;
		try {
			return unserialize(file_get_contents($this->root.str_replace("+", "-", str_replace("/", "_", base64_encode($full)))));
		}
		catch (\Exception $ex) {
			return null;
		}
	}

	public function			put($owner, $driver, $key, $content)
	{
		$full = "$owner\x00$driver\x00$key";
		if (strlen($full) >= 150)
			return;
		file_put_contents($this->root.str_replace("+", "-", str_replace("/", "_", base64_encode($full))), serialize($content));
	}

	protected			$root;
}


?>
