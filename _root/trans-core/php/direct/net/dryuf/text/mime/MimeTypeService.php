<?php

namespace net\dryuf\text\mime;


interface MimeTypeService
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			guessContentTypeFromName($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			guessContentTypeFromExtension($extension);
};


?>
