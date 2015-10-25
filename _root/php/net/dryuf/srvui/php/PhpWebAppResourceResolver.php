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
namespace net\dryuf\srvui\php;


class PhpWebAppResourceResolver extends \net\dryuf\io\AbstractResourceResolver implements \net\dryuf\core\AppContainerAware
{
	function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		$this->appContainer = $appContainer;
	}

	function			checkFileType($filename)
	{
		$fullfile = substr($filename, 0, 10) == "classpath:" ? ($this->appContainer->getWorkRoot()."php/".substr($filename, 10)) : ($this->appContainer->getAppRoot().$filename);
		if (is_file($fullfile))
			return 1;
		if (is_dir($fullfile))
			return 0;
		return -1;
	}

	function			getResource($filename)
	{
		$fd = null;
		try {
			$fd = fopen(substr($filename, 0, 10) == "classpath:" ? ($this->appContainer->getWorkRoot()."php/".substr($filename, 10)) : ($this->appContainer->getAppRoot().$filename), "rb");
		}
		catch (\Exception $ex) {
		}
		if (!$fd)
			return null;
		$fstat = fstat($fd);
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->setContentType($this->mimeTypeService->guessContentTypeFromName($filename));
		$fileData->setSize($fstat['size']);
		$fileData->setModifiedTime($fstat['mtime']*1000);
		$fileData->setInputStream($fd);
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			getResourcePaths($path)
	{
		$result = new \net\dryuf\util\php\StringNativeHashSet();
		if (strlen($path) > 0 && $path[strlen($path)-1] != '/')
			$path .= "/";
		$dir = $this->appContainer->getAppRoot().$path;
		if (is_dir($dir)) {
			foreach (\net\dryuf\io\DirUtil::filterEntries(function($file) use ($dir) { $full = $dir.$file; return is_dir($full) ? $file."/" : $file; }, $dir) as $name) {
				$result->add($name);
			}
		}
		return $result;
	}

	protected			$appContainer;

	/**
	@\javax\inject\Inject
	*/
	protected			$mimeTypeService;
}


?>
