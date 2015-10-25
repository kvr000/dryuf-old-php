<?php

namespace net\dryuf\geo;


class GeoPosition extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$created = 0;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getCreated()
	{
		return $this->created;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCreated($created)
	{
		$this->created = $created;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$lng = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLng()
	{
		return $this->lng;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLng($lng_)
	{
		$this->lng = $lng_;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$lat = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLat()
	{
		return $this->lat;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLat($lat_)
	{
		$this->lat = $lat_;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$alt = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getAlt()
	{
		return $this->alt;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAlt($alt_)
	{
		$this->alt = $alt_;
	}

	/**
	*/
	function			__construct($lng = 0, $lat = 0, $alt = 0, $created = 0)
	{
		parent::__construct();
		$this->lng = $lng;
		$this->lat = $lat;
		$this->alt = $alt;
		$this->created = $created;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\geo\GeoPosition')
	*/
	public function			cloneWithoutAlt()
	{
		return new \net\dryuf\geo\GeoPosition($this->lng, $this->lat, 0, $this->created);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			copyFullFrom($pos)
	{
		$this->created = $pos->created;
		$this->copyPositionFrom($pos);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			copyPositionFrom($pos)
	{
		$this->lat = $pos->lat;
		$this->lng = $pos->lng;
		$this->alt = $pos->alt;
	}

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	public function			computeLlDiffTo($second)
	{
		return \net\dryuf\geo\Wgs84Util::computeLlaDiff($second->lng/1.0E7, $second->lat/1.0E7, 0, $this->lng/1.0E7, $this->lat/1.0E7, 0);
	}

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	public function			computeLlaDiffTo($second)
	{
		return \net\dryuf\geo\Wgs84Util::computeLlaDiff($second->lng/1.0E7, $second->lat/1.0E7, $second->alt, $this->lng/1.0E7, $this->lat/1.0E7, $this->alt);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($so)
	{
		if (!($so instanceof \net\dryuf\geo\GeoPosition))
			return false;
		$s = $so;
		return $s->created == $this->created && $s->lng == $this->lng && $s->lat == $this->lat && $s->alt == $this->alt;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return (((($this->created*37)+$this->lng)*37+$this->lat)*37)+$this->alt;
	}
};


?>
