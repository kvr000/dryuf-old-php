<?php

namespace net\dryuf\service\time;


class SysTimeBo extends \net\dryuf\core\Object implements \net\dryuf\service\time\TimeBo
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			currentTimeMillis()
	{
		return intval(microtime(true)*1000);
	}
};


?>
