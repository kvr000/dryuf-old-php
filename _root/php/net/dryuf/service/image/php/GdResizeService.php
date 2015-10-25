<?php

namespace net\dryuf\service\image\php;


class GdResizeService implements \net\dryuf\service\image\ImageResizeService
{
	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			resizeToMaxWh($content, $maxWidth, $maxHeight, $rerotate, $suffix)
	{
		$img = imagecreatefromstring($content);
		$ow = imagesx($img);
		$oh = imagesy($img);
		$wscale = $maxWidth/$ow;
		$hscale = $maxHeight/$oh;
		if ($wscale > $hscale)
			$wscale = $hscale;
		return $this->formatImage($this->resizeScaleInternal($img, $wscale, $rerotate), $suffix);
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			resizeScale($content, $scale, $rerotate, $suffix)
	{
		$img = imagecreatefromstring($content);
		return $this->formatImage($this->resizeScaleInternal($img, $scale, $rerotate), $suffix);
	}

	function			resizeScaleInternal($img, $scale)
	{
		$ow = imagesx($img);
		$oh = imagesy($img);
		$scaledImage = imagecreatetruecolor($ow*$scale, $oh*$scale);
		imagealphablending($scaledImage, false);
		imagesavealpha($scaledImage, true);
		imagecopyresampled($scaledImage, $img, 0, 0, 0, 0, $ow*$scale, $oh*$scale, $ow, $oh);
		return $scaledImage;
	}

	function			formatImage($img, $suffix)
	{
		$imageFormatters = array(
			'jpg'			=> "imagejpeg",
			'jpeg'			=> "imagejpeg",
			'png'			=> "imagepng",
		);
		return \net\dryuf\io\IoUtil::catchStdOutput(function() use($img, $suffix, $imageFormatters) { call_user_func($imageFormatters[$suffix], $img); });
	}
};


?>
