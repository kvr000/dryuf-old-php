<?php

namespace net\dryuf\service\image\php;


class ImagickResizeService implements \net\dryuf\service\image\ImageResizeService
{
	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			resizeToMaxWh($content, $maxWidth, $maxHeight, $rerotate, $suffix)
	{
		$image = new \Imagick();
		$image->readImageBlob($content);
		$ow = $image->getImageWidth();
		$oh = $image->getImageHeight();
		$wscale = $maxWidth/$ow;
		$hscale = $maxHeight/$oh;
		if ($wscale > $hscale)
			$wscale = $hscale;
		if ($rerotate)
			$image = $this->rerotateInternal($image);
		$image = $this->resizeScaleInternal($image, $wscale);
		return $this->formatImage($image, $suffix);
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			resizeScale($content, $scale, $rerotate, $suffix)
	{
		$image = new \Imagick();
		$image->readImageBlob($content);
		if ($rerotate)
			$image = $this->rerotateInternal($image);
		$image = $this->resizeScaleInternal($image, $scale);
		return $this->formatImage($image, $suffix);
	}

	function			resizeScaleInternal($image, $scale)
	{
		$ow = $image->getImageWidth();
		$oh = $image->getImageHeight();
		$image->scaleImage(intval($ow*$scale), intval($oh*$scale));
		return $image;
	}

	function			rerotateInternal($image)
	{
		$orientation = $image->getImageOrientation(); 

		switch ($orientation) { 
		case \Imagick::ORIENTATION_BOTTOMRIGHT: 
			$image->rotateimage("#000", 180);
			break; 

		case \Imagick::ORIENTATION_RIGHTTOP: 
			$image->rotateimage("#000", 90);
			break; 

		case \Imagick::ORIENTATION_LEFTBOTTOM: 
			$image->rotateimage("#000", -90);
			break; 

		default:
			return $image;
		} 

		$image->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT); 
		return $image;
	}

	function			formatImage($img, $suffix)
	{
		$stream = fopen("php://memory", "w");
		$img->writeImageFile($stream);
		rewind($stream);
		return stream_get_contents($stream);
	}
};


?>
