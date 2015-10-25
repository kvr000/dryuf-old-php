<?php

namespace net\dryuf\service\image\php;


class PhpCaptchaService extends \net\dryuf\core\Object implements \net\dryuf\service\image\CaptchaService
{
	/**
	 */
	public function                 __construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	 */
	public function                 generateCaptcha()
	{
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->setContentType("image/jpeg");
		$capText = \net\dryuf\text\util\TextUtil::generateCode(8);
		$fileData->setName($capText);
		$bytes = $this->renderImage($capText, null);
		$fileData->setInputStream(\net\dryuf\io\IoUtil::openMemoryStream($bytes));
		$fileData->setSize(strlen($bytes));
		return $fileData;
	}

	public function			renderImage($code, $options)
	{
		if (!isset($options))
			$options = \net\dryuf\core\Options::$NONE;
		$width = $options->getOptionDefault("width", 200);
		$height = $options->getOptionDefault("height", 40);
		$font = $options->getOptionDefault("font", $this->appContainer->getWorkRoot()."share/comic.ttf");

		$img = imagecreatetruecolor($width, $height);

		$color_bg = imagecolorallocate($img, 0xf0, 0xf0, 0xf0);
		imagefilledrectangle($img, 0, 0, $width-1, $height-1, $color_bg);

		$char_width = floor(($width-4)/strlen($code));

		for ($i = 0; $i < strlen($code); $i++) {
			$cur_color = imagecolorallocate($img, rand(0, 127), rand(0, 127), rand(0, 127));
			$cur_angle = rand(-20, 20);
			$cur_size = rand($char_width-6, $char_width-2);

			// First we create our bounding box for the first text
			$bbox = imagettfbbox($cur_size, $cur_angle, $font, $code[$i]);

			// This is our cordinates for X and Y
			$x = 2+$char_width*$i+$bbox[0];
			$y = $bbox[1]+(imagesy($img)/2)-($bbox[5]/2)-5;

			// Write it
			imagettftext($img, $cur_size, $cur_angle, $x, $y, $cur_color, $font, $code[$i]);
		}

		return \net\dryuf\io\IoUtil::catchStdOutput(function() use($img) { imagejpeg($img); });
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	@\javax\inject\Inject()
	 */
	protected			$appContainer;
};


?>
