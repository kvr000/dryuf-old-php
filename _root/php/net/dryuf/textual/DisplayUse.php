<?php

namespace net\dryuf\textual;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::FIELD
})
*/
class DisplayUse extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			display() { return $this->__call("display"); }
	public function			align() { return $this->__call("align"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'align'				 => -1,
			),
			$args
		));
	}

};


?>
