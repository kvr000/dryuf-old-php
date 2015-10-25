<?php

namespace net\dryuf\core;


/**
 * Byte array manipulation functions.
 */
class ByteUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		calcCrc32($buffer, $off, $len, $init)
	{
		$crctab = array( 0, 1996959894, -301047508, -1727442502, 124634137, 1886057615, -379345611, -1637575261, 249268274, 2044508324, -522852066, -1747789432, 162941995, 2125561021, -407360249, -1866523247, 498536548, 1789927666, -205950648, -2067906082, 450548861, 1843258603, -187386543, -2083289657, 325883990, 1684777152, -43845254, -1973040660, 335633487, 1661365465, -99664541, -1928851979, 997073096, 1281953886, -715111964, -1570279054, 1006888145, 1258607687, -770865667, -1526024853, 901097722, 1119000684, -608450090, -1396901568, 853044451, 1172266101, -589951537, -1412350631, 651767980, 1373503546, -925412992, -1076862698, 565507253, 1454621731, -809855591, -1195530993, 671266974, 1594198024, -972236366, -1324619484, 795835527, 1483230225, -1050600021, -1234817731, 1994146192, 31158534, -1731059524, -271249366, 1907459465, 112637215, -1614814043, -390540237, 2013776290, 251722036, -1777751922, -519137256, 2137656763, 141376813, -1855689577, -429695999, 1802195444, 476864866, -2056965928, -228458418, 1812370925, 453092731, -2113342271, -183516073, 1706088902, 314042704, -1950435094, -54949764, 1658658271, 366619977, -1932296973, -69972891, 1303535960, 984961486, -1547960204, -725929758, 1256170817, 1037604311, -1529756563, -740887301, 1131014506, 879679996, -1385723834, -631195440, 1141124467, 855842277, -1442165665, -586318647, 1342533948, 654459306, -1106571248, -921952122, 1466479909, 544179635, -1184443383, -832445281, 1591671054, 702138776, -1328506846, -942167884, 1504918807, 783551873, -1212326853, -1061524307, -306674912, -1698712650, 62317068, 1957810842, -355121351, -1647151185, 81470997, 1943803523, -480048366, -1805370492, 225274430, 2053790376, -468791541, -1828061283, 167816743, 2097651377, -267414716, -2029476910, 503444072, 1762050814, -144550051, -2140837941, 426522225, 1852507879, -19653770, -1982649376, 282753626, 1742555852, -105259153, -1900089351, 397917763, 1622183637, -690576408, -1580100738, 953729732, 1340076626, -776247311, -1497606297, 1068828381, 1219638859, -670225446, -1358292148, 906185462, 1090812512, -547295293, -1469587627, 829329135, 1181335161, -882789492, -1134132454, 628085408, 1382605366, -871598187, -1156888829, 570562233, 1426400815, -977650754, -1296233688, 733239954, 1555261956, -1026031705, -1244606671, 752459403, 1541320221, -1687895376, -328994266, 1969922972, 40735498, -1677130071, -351390145, 1913087877, 83908371, -1782625662, -491226604, 2075208622, 213261112, -1831694693, -438977011, 2094854071, 198958881, -2032938284, -237706686, 1759359992, 534414190, -2118248755, -155638181, 1873836001, 414664567, -2012718362, -15766928, 1711684554, 285281116, -1889165569, -127750551, 1634467795, 376229701, -1609899400, -686959890, 1308918612, 956543938, -1486412191, -799009033, 1231636301, 1047427035, -1362007478, -640263460, 1088359270, 936918000, -1447252397, -558129467, 1202900863, 817233897, -1111625188, -893730166, 1404277552, 615818150, -1160759803, -841546093, 1423857449, 601450431, -1285129682, -1000256840, 1567103746, 711928724, -1274298825, -1022587231, 1510334235, 755167117 );
		$init ^= -1;
		for ($len += $off; $off < $len; $off++) {
			$init = (($init>>8)&16777215)^$crctab[(ord($buffer[$off])^$init)&255];
		}
		return $init^-1;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		calcCrc32Full($buf, $init)
	{
		return \net\dryuf\core\ByteUtil::calcCrc32($buf, 0, strlen($buf), $init);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		loadLe32($buf, $off)
	{
		return ((ord($buf[$off+3])&255)<<24)|((ord($buf[$off+2])&255)<<16)|((ord($buf[$off+1])&255)<<8)|((ord($buf[$off+0])&255)<<0);
	}

	/**
	@\net\dryuf\core\Type(type = 'short')
	*/
	public static function		loadLe16($buf, $off)
	{
		return (((ord($buf[$off+1])&255)<<0)|((ord($buf[$off+0])&255)<<8));
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		loadBe32($buf, $off)
	{
		return ((ord($buf[$off+0])&255)<<24)|((ord($buf[$off+1])&255)<<16)|((ord($buf[$off+2])&255)<<8)|((ord($buf[$off+3])&255)<<0);
	}

	/**
	@\net\dryuf\core\Type(type = 'short')
	*/
	public static function		loadBe16($buf, $off)
	{
		return (((ord($buf[$off+0])&255)<<8)|((ord($buf[$off+1])&255)<<0));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		loadString($buf, $off, $max_size)
	{
		$c = 0;
		for (;;) {
			$c = ($c<<7)+(ord($buf[$off])&127);
			$max_size--;
			if ((ord($buf[$off++])&128) == 0)
				break;
		}
		if ($c > $max_size)
			throw new \net\dryuf\core\RuntimeException("exceeded size of string");
		return (\net\dryuf\core\ByteUtil::subBytes($buf, $off, $c));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		saveLe32($buf, $off, $val)
	{
		$buf[$off+3] = chr(((((($val>>24))+0x80)&0xff)-0x80));
		$buf[$off+2] = chr(((((($val>>16))+0x80)&0xff)-0x80));
		$buf[$off+1] = chr(((((($val>>8))+0x80)&0xff)-0x80));
		$buf[$off+0] = chr(((((($val>>0))+0x80)&0xff)-0x80));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		saveLe16($buf, $off, $val)
	{
		$buf[$off+1] = chr(((((($val>>8))+0x80)&0xff)-0x80));
		$buf[$off+0] = chr(((((($val>>0))+0x80)&0xff)-0x80));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		saveBe32($buf, $off, $val)
	{
		$buf[$off+0] = chr(((((($val>>24))+0x80)&0xff)-0x80));
		$buf[$off+1] = chr(((((($val>>16))+0x80)&0xff)-0x80));
		$buf[$off+2] = chr(((((($val>>8))+0x80)&0xff)-0x80));
		$buf[$off+3] = chr(((((($val>>0))+0x80)&0xff)-0x80));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		saveBe16($buf, $off, $val)
	{
		$buf[$off+0] = chr(((((($val>>8))+0x80)&0xff)-0x80));
		$buf[$off+1] = chr(((((($val>>0))+0x80)&0xff)-0x80));
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		subBytes($b, $off, $len)
	{
		$r = implode(array_map('chr', \net\dryuf\core\Dryuf::allocArray(0, $len)));
		(=f_I_x=)System.arraycopy(b, off, r, 0, len)(=x_I_f=);
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		subBytes($b, $off)
	{
		$r = implode(array_map('chr', \net\dryuf\core\Dryuf::allocArray(0, strlen($b)-$off)));
		(=f_I_x=)System.arraycopy(b, off, r, 0, b.length - off)(=x_I_f=);
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		concatBytes($b0, $b1)
	{
		$r = implode(array_map('chr', \net\dryuf\core\Dryuf::allocArray(0, strlen($b0)+strlen($b1))));
		(=f_I_x=)System.arraycopy(b0, 0, r, 0, b0.length)(=x_I_f=);
		(=f_I_x=)System.arraycopy(b1, 0, r, b0.length, b1.length)(=x_I_f=);
		return $r;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		cmpBytes($b0, $off, $cmp)
	{
		for ($p = 0; $p < strlen($cmp); $p++) {
			if ($off+$p >= strlen($b0))
				return -1;
			elseif (ord($b0[$off+$p]) != ord($cmp[$p]))
				return ord($b0[$off+$p])-ord($cmp[$p]);
		}
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		copyFullBytes($dst, $off, $src)
	{
		(=f_I_x=)System.arraycopy(src, 0, dst, off, src.length)(=x_I_f=);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		findByte($buf, $needle, $off)
	{
		for (; $off < strlen($buf); $off++) {
			if (ord($buf[$off]) == $needle)
				return $off;
		}
		return -1;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		dumpBytes($data)
	{
		$buf = new \net\dryuf\core\StringBuilder();
		for ($i = 0; $i < strlen($data); $i++) {
			$buf->append(' ');
			if ($i > 0 && $i%8 == 0)
				$buf->append(' ');
			$b = ord($data[$i]);
			$f = (((((($b>>4)&15))+0x80)&0xff)-0x80);
			$buf->append(chr(($f < 10 ? (ord('0')+$f) : (ord('A')+$f-10))));
			$s = (((((($b>>0)&15))+0x80)&0xff)-0x80);
			$buf->append(chr(($s < 10 ? (ord('0')+$s) : (ord('A')+$s-10))));
		}
		return strval($buf);
	}
};


?>
