<?php

namespace net\dryuf\oper\ObjectOperController;


class StringContainer extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$content;

	/**
	*/
	function			__construct($content)
	{
		parent::__construct();
		$this->content = $content;
	}
};


?>
