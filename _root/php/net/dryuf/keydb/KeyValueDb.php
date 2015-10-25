<?php

namespace net\dryuf\keydb;


interface KeyValueDb
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			findOrDefault($key, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	function			listPrefixedStrip($prefix);
};


?>
