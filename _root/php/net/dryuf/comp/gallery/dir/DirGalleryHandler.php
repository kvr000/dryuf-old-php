<?php

namespace net\dryuf\comp\gallery\dir;


class DirGalleryHandler extends \net\dryuf\comp\gallery\SimpleGalleryHandler
{
	/**
	*/
	function			__construct($callerContext, $galleryDir)
	{
		parent::__construct($callerContext, $galleryDir);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			read()
	{
		if (!is_null($this->sections))
			return;
		$files = new \net\dryuf\util\LinkedList();
		foreach ($this->getCallerContext()->getBeanTyped("resourceResolver", 'net\dryuf\io\ResourceResolver')->getResourcePaths($this->galleryDir) as $file) {
			if (is_null(($match = \net\dryuf\core\StringUtil::matchText(".*/([^/]+\\.(jpg|jpeg|png|gif))\$", $file))))
				continue;
			$files->add($match[1]);
		}
		\net\dryuf\util\Collections::sort($files);
		$this->initFromList($files, null);
	}
};


?>
