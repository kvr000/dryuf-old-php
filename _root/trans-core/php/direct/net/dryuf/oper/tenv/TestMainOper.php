<?php

namespace net\dryuf\oper\tenv;


class TestMainOper extends \net\dryuf\oper\DaoObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->setDataClass('net\dryuf\tenv\TestMain');
	}
};


?>
