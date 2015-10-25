<?php

namespace net\dryuf\core;


/**
 * Dynamic type utilities.
 */
class VariantUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public static function		scalarEmpty($scalar)
	{
		if (is_null($scalar))
			return true;
		elseif (is_bool($scalar))
			return !\net\dryuf\core\Dryuf::convertBool($scalar);
		elseif (is_numeric($scalar))
			return intval($scalar) == 0;
		elseif (is_string($scalar))
			return ($scalar === "");
		else
			throw new \net\dryuf\core\RuntimeException("unexpected Object passed to scalarEmpty: ".get_class($scalar));
	}
};


?>
