<?php

namespace net\dryuf\serialize;


interface DataMarshaller
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getMimeType();

	/**
	@\net\dryuf\core\Type(type = 'java\io\OutputStream')
	*/
	function			marshal($stream, $object);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			unmarshal($stream, $clazz);
};


?>
