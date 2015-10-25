<?php

namespace net\dryuf\oper;


class DummyOper extends \net\dryuf\oper\DaoObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->setDataClass('net\dryuf\security\UserAccount');
	}
};


?>
