<?php

namespace net\dryuf\mvp;


interface StaticRenderer
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			prepare($parentPresenter, $obj);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			render($parentPresenter, $obj, $carrier);
};


?>
