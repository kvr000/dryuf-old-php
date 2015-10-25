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

namespace net\dryuf\mvp;


class DefaultServletPresenter extends \net\dryuf\mvp\ChildPresenter
{
	public static function		readRemainingPathSafe($presenter)
	{
		$rootPresenter = $presenter->getRootPresenter();
		$path = "";
		while (!is_null($element = $rootPresenter->getPathElement())) {
			if (preg_match('/^(\.|\.\.|\.ht.*|.*\/.*)$/', $element))
				throw new \net\dryuf\core\Exception("invalid path element: $element");
			$path .= $element;
			if (substr($rootPresenter->getCurrentPath(), -1) == "/")
				$path .= "/";
		}
		return $path;
	}

	public static function		createSafeAndProcess($parentPresenter)
	{
		$this_ = new \net\dryuf\mvp\DefaultServletPresenter($parentPresenter, \net\dryuf\core\Options::$NONE);
		return $this_->process();
	}

	public function			process()
	{
		$this->mimeTypeService = $this->getCallerContext()->getBeanTyped("mimeTypeService", 'net.dryuf.text.mime.MimeTypeService');
		$this->path = $this->getRootPresenter()->getRealPath().self::readRemainingPathSafe($this);
		return $this->processFinal();
	}

	public function			startProcessing()
	{
		global $_SERVER;

		if (is_dir($this->path)) {
			if (is_null($this->getRootPresenter()->needPathSlash(true)))
				return true;
			throw new \net\dryuf\core\Exception("directory listing unsupported");
		}
		try {
			$this->fd = \net\dryuf\io\FileUtil::openFileRead($this->path);
		}
		catch (\net\dryuf\core\Exception $ex) {
			$this->parentPresenter->createNotFoundPresenter();
			return true;
		}
		$this->getRootPresenter()->setLeadChild($this);
		$stat = fstat($this->fd);
		$this->size = $stat[7];
		if (isset(\net\dryuf\core\Dryuf::$config['webcache']) && array_key_exists('HTTP_IF_MODIFIED_SINCE', $_SERVER) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $stat[7]) {
			header($_SERVER['SERVER_PROTOCOL'].' 304 Not Modified');
		}
		else {
			if (isset($_SERVER['HTTP_RANGE'])) {
				if (!preg_match('/^bytes=(\d*)-(\d*)$/', $_SERVER['HTTP_RANGE'], $match))
					throw new \RuntimeException("Invalid Range header: ".$_SERVER['HTTP_RANGE']);
				$this->start = $match[1] == "" ? null : intval($match[1]);
				$this->end = $match[2] == "" ? null : intval($match[2]);
				if (is_null($this->start)) {
					if (is_null($this->end))
						throw new \RuntimeException("Invalid Range header, both start and end are empty: ".$_SERVER['HTTP_RANGE']);
					$this->start = $this->size-$this->end;
					$this->end = $this->size;
				}
				elseif (is_null($this->end)) {
					$this->end = $this->size;
				}
				else {
					++$this->end;
				}
				if ($this->start < 0 || $this->end > $this->size || $this->start > $this->end) {
					$this->getResponse()->sendError(416, "Requested Range Not Satisfiable");
					$this->getResponse()->setHeader("Content-Range", "*/".$this->size);
					$this->fd = null;
					return false;
				}
				$this->getRootPresenter()->getResponse()->sendStatus(206, "Partial Content");
				header("Content-Range: bytes $this->start-".($this->end-1)."/$this->size");
			}
			else {
				header("Content-Length: ".$this->size);
			}
			if (isset(\net\dryuf\core\Dryuf::$config['webcache']))
				header("Cache-Control: max-age=".\net\dryuf\core\Dryuf::$config['webcache']);
			header("Content-Type: ".\net\dryuf\core\Dryuf::defvalue($this->mimeTypeService->guessContentTypeFromName($this->path), "application/octet-stream"));
			header("Last-Modified: ".date("r", $stat[9]));
			header("Accept-Range: bytes");
		}
		return false;
	}

	public function			processHead()
	{
		$ret = $this->startProcessing();
		return $ret;
	}

	public function			processCommon()
	{
		$ret = $this->startProcessing();
		if ($this->fd) {
			if (!is_null($this->start)) {
				$offset = $this->start;
				if (true) {
					if (stream_copy_to_stream($this->fd, $this->getRootPresenter()->getResponse()->getOutputStream(), !is_null($this->end) ? -1 : $this->end-$this->start, $this->start) != $this->end-$this->start) {
						throw new \RuntimeException("failed to copy all bytes");
					}
				}
				else {
					fseek($this->fd, $this->start, SEEK_SET);
					if (!is_null($this->end)) {
						while ($offset < $this->end) {
							$toread = $this->end-$offset < 16384 ? $this->end-$offset : 16384;
							if (($buf = fread($this->fd, $toread)) === false)
								throw new \RuntimeException("Error while reading from file");
							print($buf);
							$offset += strlen($buf);
						}
					}
					else {
						fpassthru($this->fd);
					}
				}
			}
			else {
				fpassthru($this->fd);
			}
			fclose($this->fd);
		}
		return $ret;
	}

	protected			$path;

	protected			$fd;

	protected			$size;

	protected			$start;

	protected			$end;

	protected			$mimeTypeService;
};


?>
