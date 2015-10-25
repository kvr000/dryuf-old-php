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


class FileUtil
{
	static function			getFileContent($fname)
	{
		if (($content = @file_get_contents($fname)) !== false)
			return $content;
		throw new \net\dryuf\io\FileException("cannot read file $fname: ".\net\dryuf\core\Dryuf::lastErrorDesc(), $fname);
	}

	static function			putFileContent($fname, $content)
	{
		if (@file_put_contents($fname, $content) === false)
			throw new \net\dryuf\io\FileException("cannot write file $fname: ".\net\dryuf\core\Dryuf::lastErrorDesc(), $fname);
	}

	static function			getExtension($fname)
	{
		if (preg_match('/\.(\w+)$/', $fname, $match))
			return $match[1];
		return null;
	}

	static function			getCommentedFileContent($fname)
	{
		return preg_replace('/^#.*?\n/m', '', \net\dryuf\io\FileUtil::getFileContent($fname));
	}

	static function			createFileTruncated($fname)
	{
		if (!($fd = @fopen($fname, "w")))
			throw new \net\dryuf\io\FileException("cannot open file $fname for writing: ".\net\dryuf\core\Dryuf::lastErrorDesc());
		return $fd;
	}

	static function			openFileRead($fname)
	{
		if (($fd = fopen($fname, "r")))
			return $fd;
		throw new \net\dryuf\io\FileException("cannot open file $fname for reading: ".\net\dryuf\core\Dryuf::lastErrorDesc(), $fname);
	}
};


?>
