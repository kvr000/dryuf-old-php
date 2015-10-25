<?php

namespace net\dryuf\oper;


class ObjectOperRules extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			value() { return $this->__call("value"); }
	public function			reqRole() { return $this->__call("reqRole"); }
	public function			isStatic() { return $this->__call("isStatic"); }
	public function			isFinal() { return $this->__call("isFinal"); }
	public function			parameters() { return $this->__call("parameters"); }
	public function			actionClass() { return $this->__call("actionClass"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'value'				 => "",
				'reqRole'			 => "",
				'isStatic'			 => false,
				'isFinal'			 => false,
				'parameters'			 => array( ),
				'actionClass'			 => 'void',
			),
			$args
		));
	}

};


?>
