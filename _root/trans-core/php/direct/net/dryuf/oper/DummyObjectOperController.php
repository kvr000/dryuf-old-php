<?php

namespace net\dryuf\oper;


class DummyObjectOperController extends \net\dryuf\oper\AbstractObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getDataClass()
	{
		return null;
	}
};


?>
