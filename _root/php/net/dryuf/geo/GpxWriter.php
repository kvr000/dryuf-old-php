<?php

namespace net\dryuf\geo;


class GpxWriter extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static			$GPX_URI = "http://www.topografix.com/GPX/1/1";

	/**
	 * Date format for a point timestamp.
	 */
	/**
	*/
	function			__construct($stream)
	{
		parent::__construct();
		$this->stream = $stream;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\GpxWriter')
	*/
	public function			endElement()
	{
		$this->stream->writeEndElement();
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\GpxWriter')
	*/
	public function			startGpx()
	{
		$this->stream->writeStartDocument();
		$this->stream->writeStartElement("gpx");
		$this->stream->writeDefaultNamespace(self::$GPX_URI);
		$this->stream->writeAttribute("version", "1.1");
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\GpxWriter')
	*/
	public function			endGpx()
	{
		$this->endElement();
		$this->stream->close();
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\GpxWriter')
	*/
	public function			writeTrack($positions)
	{
		$this->stream->writeStartElement(self::$GPX_URI, "trk");
		$this->stream->writeStartElement(self::$GPX_URI, "trkseg");
		$this->stream->writeCharacters("\n");
		foreach ($positions as $position) {
			$this->stream->writeStartElement(self::$GPX_URI, "trkpt");
			$this->stream->writeAttribute("lon", sprintf(\java\util\Locale::$ENGLISH, "%.7g", $position->lng/1.0E7));
			$this->stream->writeAttribute("lat", sprintf(\java\util\Locale::$ENGLISH, "%.7g", $position->lat/1.0E7));
			$this->stream->writeStartElement(self::$GPX_URI, "time");
			$this->stream->writeCharacters(\net\dryuf\time\util\DateTimeUtil::formatUtcIso($position->created));
			$this->stream->writeEndElement();
			$this->stream->writeEndElement();
			$this->stream->writeCharacters("\n");
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
