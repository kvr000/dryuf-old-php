<?php

namespace net\dryuf\core;


/**
 * Provides simple key-value data cache.
 */
interface DataCache
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			get($owner, $driver, $key);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			put($owner, $driver, $key, $value);
};


?>
