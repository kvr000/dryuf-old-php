<?php

namespace net\dryuf\geo;


class KmlWriter extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static			$KML_URI = "http://www.opengis.net/kml/2.2";

	/**
	*/
	function			__construct($stream)
	{
		parent::__construct();
		$this->stream = $stream;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\KmlWriter')
	*/
	public function			endElement()
	{
		$this->stream->writeEndElement();
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\KmlWriter')
	*/
	public function			startKml()
	{
		$this->stream->writeStartDocument();
		$this->stream->writeStartElement("kml");
		$this->stream->writeDefaultNamespace(self::$KML_URI);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\KmlWriter')
	*/
	public function			endKml()
	{
		$this->endElement();
		$this->stream->close();
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\KmlWriter')
	*/
	public function			startDocument()
	{
		$this->stream->writeStartElement(self::$KML_URI, "Document");
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\KmlWriter')
	*/
	public function			startPlacemark()
	{
		$this->stream->writeStartElement(self::$KML_URI, "Placemark");
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\KmlWriter')
	*/
	public function			writeLineString($positions)
	{
		$this->stream->writeStartElement(self::$KML_URI, "LineString");
		$this->stream->writeStartElement(self::$KML_URI, "coordinates");
		$this->stream->writeCharacters("\n");
		foreach ($positions as $position) {
			$this->stream->writeCharacters(sprintf(\java\util\Locale::$ENGLISH, "%.7g,%.7g,%d\n", $position->lng/1.0E7, $position->lat/1.0E7, $position->alt));
		}
		$this->stream->writeEndElement();
		$this->stream->writeEndElement();
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\xml\stream\XMLStreamWriter')
	*/
	public				$stream;
};


?>
