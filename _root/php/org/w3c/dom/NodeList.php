<?php

namespace org\w3c\dom;


interface NodeList
{
	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Node')
	*/
	public function			item($index);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLength();
};


?>
