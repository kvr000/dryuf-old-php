<?php

namespace net\dryuf\meta;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::FIELD
})
*/
class Mandatory extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			mandatory() { return $this->__call("mandatory"); }
	public function			doMandatory() { return $this->__call("doMandatory"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'doMandatory'			 => "",
			),
			$args
		));
	}

};


?>
