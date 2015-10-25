<?php

namespace net\dryuf\textual;


class ImageFileTextual extends \net\dryuf\textual\FileTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		checkImageName($callerContext, $filename)
	{
		if (!is_null(($error = \net\dryuf\textual\FileTextual::checkFileName($callerContext, $filename))))
			return $error;
		if (is_null(\net\dryuf\core\StringUtil::matchText("^[-a-zA-Z0-9_]+\\.(jpg|jpeg|png|PNG|JPG|JPEG)\$", $filename)))
			return $callerContext->getUiContext()->localize('net\dryuf\textual\ImageFileTextual', "Image file of type png or jpeg expected (suffix jpg, jpeg, png)").": ".$filename;
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($input)
	{
		return \net\dryuf\textual\ImageFileTextual::checkImageName($this->callerContext, $input);
	}
};


?>
