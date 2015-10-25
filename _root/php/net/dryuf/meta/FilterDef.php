<?php

namespace net\dryuf\meta;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::TYPE
})
*/
class FilterDef extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			name() { return $this->__call("name"); }
	public function			condition() { return $this->__call("condition"); }
};


?>
