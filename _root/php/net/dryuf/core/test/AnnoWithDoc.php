<?php

namespace net\dryuf\core\test;


/**
 * Some documentation here.
@\net\dryuf\core\test\TestAnnotationOne(value = "value")
@\net\dryuf\core\test\TestAnnotationTwo(value = "value")
*/
class AnnoWithDoc extends \net\dryuf\core\Object
{
	function			__construct()
	{
		parent::__construct();
	}

	/**
	 * Dummy link in the middle {@link AnnoParent}.
	@\net\dryuf\core\test\TestAnnotationOne(value = "value")
	@\net\dryuf\core\test\TestAnnotationTwo(value = "value")
	*/
	public				$field = 0;

	/**
	 * {@link AnnoParent} dummy link at the beginning.
	@\net\dryuf\core\test\TestAnnotationOne(value = "value")
	@\net\dryuf\core\test\TestAnnotationTwo(value = "value")
	*/
	public function			method()
	{
	}
};


?>
