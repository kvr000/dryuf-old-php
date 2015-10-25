<?php

namespace net\dryuf\geo;


class Wgs84Util extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_A = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_B = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_F = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_Ecc = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_Esq = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_FE = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_ONE_M_FE = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_E2 = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	static				$EARTH_EPSILON = 0.0;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		convertLlaToXyz(&$xyz, $lng, $lat, $alt)
	{
		$slat = sin($lat*(M_PI/180));
		$clat = cos($lat*(M_PI/180));
		$slng = sin($lng*(M_PI/180));
		$clng = cos($lng*(M_PI/180));
		$dsq = 1.0-self::$EARTH_Esq*$slat*$slat;
		$rn = self::$EARTH_A/sqrt($dsq);
		$xyz[0] = ($rn+$alt)*$clat*$clng;
		$xyz[1] = ($rn+$alt)*$clat*$slng;
		$xyz[2] = ((1-self::$EARTH_Esq)*$rn+$alt)*$slat;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			convertXyzToLla(&$lla, $xyz)
	{
		$x = $xyz[0];
		$y = $xyz[1];
		$z = $xyz[2];
		if ($x == 0 && $y == 0 && $z == 0) {
		}
		elseif ($x == 0 && $y == 0 && $z != 0) {
			$lla[0] = 0;
			$lla[1] = (($z < 0) ? -1 : 1)*M_PI/2;
			$lla[2] = abs($z)-self::$EARTH_B;
		}
		elseif ($z == 0.0) {
			$lla[0] = atan2($y, $x);
			$lla[1] = 0;
			$p = sqrt($x*$x+$y*$y);
			$lla[2] = $p-self::$EARTH_A;
		}
		else {
			$p2 = $x*$x+$y*$y;
			$r2 = $p2+$z*$z;
			$p = sqrt($p2);
			$r = sqrt($r2);
			$tanu = self::$EARTH_ONE_M_FE*($z/$p)*(1+(self::$EARTH_EPSILON*self::$EARTH_B)/$r);
			$tan2u = $tanu*$tanu;
			$cos2u = 1.0/(1.0+$tan2u);
			$cosu = sqrt($cos2u);
			$cos3u = $cos2u*$cosu;
			$sinu = $tanu*$cosu;
			$sin2u = 1+0-$cos2u;
			$sin3u = $sin2u*$sinu;
			$tanlat = ($z+self::$EARTH_EPSILON*self::$EARTH_B*$sin3u)/($p-self::$EARTH_E2*self::$EARTH_A*$cos3u);
			$tan2lat = $tanlat*$tanlat;
			$cos2lat = 1+0/(1+0+$tan2lat);
			$sin2lat = 1+0-$cos2lat;
			$coslat = sqrt($cos2lat);
			$sinlat = $tanlat*$coslat;
			$lla[0] = atan2($y, $x);
			$lla[1] = atan($tanlat);
			$lla[2] = $p*$coslat+$z*$sinlat-self::$EARTH_A*sqrt(1+0-self::$EARTH_E2*$sin2lat);
		}
		$lla[0] *= 180/M_PI;
		$lla[1] *= 180/M_PI;
	}

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	public static function		computeLlaDiff($lng0, $lat0, $alt0, $lng1, $lat1, $alt1)
	{
		$p0 = array_fill(0, 3, 0);
		$p1 = array_fill(0, 3, 0);
		\net\dryuf\geo\Wgs84Util::convertLlaToXyz($p0, $lng0, $lat0, $alt0);
		\net\dryuf\geo\Wgs84Util::convertLlaToXyz($p1, $lng1, $lat1, $alt1);
		return sqrt(($p0[0]-$p1[0])*($p0[0]-$p1[0])+($p0[1]-$p1[1])*($p0[1]-$p1[1])+($p0[2]-$p1[2])*($p0[2]-$p1[2]));
	}

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	public static function		computeLlDiff($lng0, $lat0, $lng1, $lat1)
	{
		$p0 = array_fill(0, 3, 0);
		$p1 = array_fill(0, 3, 0);
		\net\dryuf\geo\Wgs84Util::convertLlaToXyz($p0, $lng0, $lat0, 0);
		\net\dryuf\geo\Wgs84Util::convertLlaToXyz($p1, $lng1, $lat1, 0);
		return sqrt(($p0[0]-$p1[0])*($p0[0]-$p1[0])+($p0[1]-$p1[1])*($p0[1]-$p1[1])+($p0[2]-$p1[2])*($p0[2]-$p1[2]));
	}

	public static function		_initManualStatic()
	{
		{
			self::$EARTH_A = 6378137;
			self::$EARTH_F = 1.0/298.257223563;
			self::$EARTH_B = self::$EARTH_A*(1.0-self::$EARTH_F);
			self::$EARTH_Esq = 1-self::$EARTH_B*self::$EARTH_B/(self::$EARTH_A*self::$EARTH_A);
			self::$EARTH_Ecc = sqrt(self::$EARTH_Esq);
			self::$EARTH_FE = 1.0/298.257223563;
			self::$EARTH_ONE_M_FE = 1.0-self::$EARTH_FE;
			self::$EARTH_E2 = self::$EARTH_FE*(2.0-self::$EARTH_FE);
			self::$EARTH_EPSILON = self::$EARTH_E2/(1.0-self::$EARTH_E2);
		}
	}

};

\net\dryuf\geo\Wgs84Util::_initManualStatic();


?>
