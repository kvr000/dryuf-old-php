<?php

namespace net\dryuf\core\php;


class PhpAnnotationBase
{
	public function			__construct($attrs = array())
	{
		$this->__anno_attrs = $attrs;
	}

	public function			__call($name, $args = null)
	{
		return $this->__anno_attrs[$name];
	}

	protected			$__anno_attrs;
}


?>
