<?php

namespace net\dryuf\service\image;


interface CaptchaService
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			generateCaptcha();
};


?>
