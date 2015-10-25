<?php

namespace net\dryuf\core;


/**
 * Dynamic entity view data.
 */
interface EntityView
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addDynamic($key, $value);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getDynamic($key);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getDynamicDefault($key, $defaultValue);
};


?>
