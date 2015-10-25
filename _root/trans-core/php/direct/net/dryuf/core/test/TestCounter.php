<?php

namespace net\dryuf\core\test;


class TestCounter extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->counter = 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			inc()
	{
		$this->counter++;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			get()
	{
		return $this->counter;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$counter = 0;
};


?>
