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


class IoUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		readFullBytes($reader)
	{
		return stream_get_contents($reader);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		readFullString($reader)
	{
		return stream_get_contents($reader);
	}

	static function			openMemoryStream($content)
	{
		$fd = fopen("php://memory", "r+");
		fwrite($fd, $content);
		rewind($fd);
		return $fd;
	}

	static function			readMemoryStreamContent($fd)
	{
		rewind($fd);
		return stream_get_contents($fd);
	}

	static function			writeFully($fd, $content)
	{
		for ($pos = 0; $pos < strlen($content); ) {
			if (($w = fwrite($fd, substr($content, $pos))) === false)
				throw new \net\dryuf\core\Exception("failed to write to file");
			$pos += $w;
		}
		return $pos;
	}

	static function			catchStdOutput($runnable)
	{
		ob_start();
		try {
			call_user_func($runnable);
		}
		catch (\Exception $ex) {
			return ob_end_clean();
		}
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}
};


?>
