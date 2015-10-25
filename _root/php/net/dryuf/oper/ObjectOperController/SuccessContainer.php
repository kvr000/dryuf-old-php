<?php

namespace net\dryuf\oper\ObjectOperController;


class SuccessContainer extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public				$result = false;

	/**
	*/
	function			__construct($result)
	{
		parent::__construct();
		$this->result = $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController\SuccessContainer')
	*/
	public static function		getOk()
	{
		return new \net\dryuf\oper\ObjectOperController\SuccessContainer(true);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController\SuccessContainer')
	*/
	public static function		getFailed()
	{
		return new \net\dryuf\oper\ObjectOperController\SuccessContainer(false);
	}
};


?>
