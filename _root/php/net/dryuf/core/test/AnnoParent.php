<?php

namespace net\dryuf\core\test;


/**
@\net\dryuf\core\test\TestAnnotationOne(value = "parent")
@\net\dryuf\core\test\TestAnnotationTwo(value = "parent")
*/
class AnnoParent extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	@\net\dryuf\core\test\TestAnnotationOne(value = "parent")
	@\net\dryuf\core\test\TestAnnotationTwo(value = "parent")
	*/
	public				$field = 0;

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\net\dryuf\core\test\TestAnnotationOne(value = "parent")
	@\net\dryuf\core\test\TestAnnotationTwo(value = "parent")
	*/
	public function			method()
	{
	}
};


?>
