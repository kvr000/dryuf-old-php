<?php

namespace net\dryuf\core\test;


/**
@\net\dryuf\core\test\TestAnnotationTwo(value = "child")
@\net\dryuf\core\test\TestAnnotationThree(value = "child")
*/
class AnnoChild extends \net\dryuf\core\test\AnnoParent
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	@\net\dryuf\core\test\TestAnnotationTwo(value = "child")
	@\net\dryuf\core\test\TestAnnotationThree(value = "child")
	*/
	public				$field = 0;

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\net\dryuf\core\test\TestAnnotationTwo(value = "child")
	@\net\dryuf\core\test\TestAnnotationThree(value = "child")
	*/
	public function			method()
	{
	}
};


?>
