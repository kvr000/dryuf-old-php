<?php

namespace net\dryuf\text\markdown;


interface MarkdownService
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Integer, java\lang\String>')
	*/
	function			validateInput($input);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			convertToXhtml($input);
};


?>
