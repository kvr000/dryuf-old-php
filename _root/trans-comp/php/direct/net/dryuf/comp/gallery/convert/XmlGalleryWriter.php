<?php

namespace net\dryuf\comp\gallery\convert;


class XmlGalleryWriter extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($callerContext, $out)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
		$this->out = $out;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			writeRaw($s)
	{
		try {
			fwrite($this->out, $s);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startOutput()
	{
		$this->writeRaw("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
		$this->writeRaw("<gallery\n\txmlns=\"http://dryuf.org/schema/net/dryuf/comp/gallery/xml/gallery/\"\n\txmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n\txsi:schemaLocation=\"\n\t\thttp://dryuf.org/schema/net/dryuf/comp/gallery/xml/gallery/ http://www.znj.cz/schema/net/dryuf/comp/gallery/xml/gallery.xsd\n\t\">\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			finishOutput()
	{
		$this->writeRaw("</gallery>\n");
		try {
			fflush($this->out);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openLocations()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t<locations>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openLocation($options)
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t<location id=%A store=%A thumb=%A>\n", $options->getOptionMandatory("id"), $options->getOptionMandatory("store"), $options->getOptionMandatory("thumb"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeLocation()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t</location>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeLocations()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t</locations>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openSections($isMulti)
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t<sections multi=%A>\n", $isMulti ? 1 : 0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			writeOptionalElement($indent, $element, $options, $option)
	{
		if (!is_null(($value = $options->getOptionDefault($option, null)))) {
			for (; $indent > 0; $indent--)
				\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t");
			\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "<".$element.">%S</".$element.">\n", $value);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			writeOptionalAttr($attr, $options, $option)
	{
		if (!is_null(($value = $options->getOptionDefault($option, null)))) {
			\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, " %s=%A", $attr, $value);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openSection($options)
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t<section id=%A location=%A>\n", $options->getOptionMandatory("id"), $options->getOptionMandatory("location"));
		$this->writeOptionalElement(3, "title", $options, "title");
		$this->writeOptionalElement(3, "description", $options, "description");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openRecords()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t<records>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openRecord($options)
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t\t<record file=%A", $options->getOptionMandatory("file"));
		$this->writeOptionalAttr("recordType", $options, "recordType");
		$this->writeOptionalAttr("location", $options, "location");
		$this->writeRaw(">\n");
		$this->writeOptionalElement(5, "description", $options, "description");
		$this->writeOptionalElement(5, "title", $options, "title");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openSources()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t\t\t<sources>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			openSource($options)
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t\t\t\t<source");
		$this->writeOptionalAttr("file", $options, "file");
		$this->writeOptionalAttr("mimeType", $options, "mimeType");
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, ">");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeSource()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "</source>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeSources()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t\t\t</sources>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeRecord()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t\t</record>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeRecords()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t\t</records>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeSection()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t\t</section>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			closeSections()
	{
		\net\dryuf\xml\util\XmlFormat::formatStream($this->out, $this->callerContext, "\t</sections>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\OutputStream')
	*/
	protected			$out;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;
};


?>
