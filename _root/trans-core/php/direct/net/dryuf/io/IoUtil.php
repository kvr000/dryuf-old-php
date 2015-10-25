<?php

namespace net\dryuf\io;


class IoUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		readFullBytes($reader)
	{
		$out = \net\dryuf\io\IoUtil::openMemoryStream("");
		$buf = implode(array_map('chr', array_fill(0, 16384, 0)));
		try {
			while (($readed = (=f_I_x=)reader.read(buf, 0, buf.length)(=x_I_f=)) > 0)
				(=f_I_x=)out.write(buf, 0, readed)(=x_I_f=);
		}
		catch (\net\dryuf\io\IoException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
		return \net\dryuf\io\IoUtil::readMemoryStreamContent($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		readFullString($reader)
	{
		$out = new \java\lang\StringBuffer();
		$buf = array_fill(0, 16384, 0);
		try {
			while (($readed = $reader->read($buf, 0, count($buf))) > 0)
				$out->append($buf, 0, $readed);
		}
		catch (\net\dryuf\io\IoException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
		return strval($out);
	}
};


?>
