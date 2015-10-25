<?php

namespace net\dryuf\service\image;


interface ImageResizeService
{
	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			resizeToMaxWh($content, $maxWidth, $maxHeight, $rerotate, $suffix);

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			resizeScale($content, $scale, $rerotate, $suffix);
};


?>
