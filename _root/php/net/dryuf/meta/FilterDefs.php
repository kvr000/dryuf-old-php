<?php

namespace net\dryuf\meta;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::TYPE
})
*/
class FilterDefs extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			filters() { return $this->__call("filters"); }
};


?>
