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

namespace net\dryuf\io;


class DirUtil
{
	/**
	 * Filters the entries in $dirname through $filter callback returning non-null value to be returned.
	 * @return
	 * 	the list of filtered entries or whatever the filter returns
	 */
	static function			filterEntries($filter, $dirname)
	{
		$list = array();
		foreach (scandir($dirname) as $file) {
			if ($file != "." && $file != ".." && !is_null($ret = call_user_func($filter, $file))) {
				array_push($list, $ret);
			}
		}
		return $list;
	}

	/**
	 * Filters the entries (files only) in $dirname through $filter callback returning non-null value to be
	 * returned.
	 * @return
	 * 	the list of filtered files or whatever the filter returns
	 */
	static function			filterFiles($filter, $dirname)
	{
		return self::filterEntries(function($file) use ($dirname, $filter) { return is_file("$dirname/$file") ? call_user_func($filter, $file) : null; }, $dirname);
	}

	/**
	 * Filters the entries (directories only) in $dirname through $filter callback returning non-null value to be
	 * returned.
	 * @return
	 * 	the list of filtered directories or whatever the filter returns
	 */
	static function			filterDirectories($filter, $dirname)
	{
		return self::filterEntries(function($file) use ($dirname, $filter) { return is_dir("$dirname/$file") ? call_user_func($filter, $file) : null; }, $dirname);
	}

	static function			mkpath($path, $force_perm = null)
	{
		if (is_dir($path))
			return;
		try {
			is_null($force_perm) ? mkdir($path) : mkdir($path, $force_perm);
			if (!is_null($force_perm))
				chmod($path, $force_perm);
		}
		catch (\net\dryuf\core\Exception $ex) {
			self::mkpath(dirname($path), $force_perm);
			try {
				is_null($force_perm) ? mkdir($path) : mkdir($path, $force_perm);
				if (!is_null($force_perm))
					chmod($path, $force_perm);
			}
			catch (\net\dryuf\core\Exception $ex) {
				if (!is_dir($path))
					throw $ex;
			}
		}
	}

	static function			rmpath($path)
	{
		if (is_dir($path))
			return;
		foreach (scandir($path) as $file) {
			if ($file != "." && $file != "..") {
				$full = $path."/".$file;
				if (is_dir($full))
					self::rmpath($full);
				else
					unlink($full);
			}
		}
	}

	static function			removeRecursive($path)
	{
		try {
			if (!rmdir($path))
				throw new \net\dryuf\core\Exception("failed");
		}
		catch (\net\dryuf\core\Exception $ex) {
			if (!file_exists($path))
				return false;
			foreach (self::filterEntries(function($entry) { return $entry; }, $path) as $entry) {
				if (is_dir($entry)) {
					self::removeRecursive("$path/$entry");
				}
				else {
					unlink("$path/$entry");
				}
			}
			rmdir($path);
			return true;
		}
	}
};


?>
