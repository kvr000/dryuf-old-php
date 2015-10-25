<?php

namespace net\dryuf\comp\gallery\xml;


class XmlGalleryHandler extends \net\dryuf\comp\gallery\SimpleGalleryHandler
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
		$parser = new \net\dryuf\xml\XmlMappedParser();
		$this->read_init();
		new \net\dryuf\comp\gallery\xml\XmlGalleryHandler\Reader($this, $parser);
		$parser->processStream($this->callerContext->getBeanTyped("resourceResolver", 'net\dryuf\io\ResourceResolver')->getMandatoryResourceAsStream($this->galleryDir."gallery.xml"));
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			supportsResource($name)
	{
		return ($name === "gallery.xml") ? $this->getCallerContext()->checkRole("Gallery.config") ? 1 : -1 : 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isMulti()
	{
		return $this->isMulti;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public				$isMulti = false;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlMappedTree')
	*/
	static				$readMapping = null;
};


?>
