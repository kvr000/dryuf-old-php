<?php

namespace net\dryuf\meta;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::TYPE
})
*/
class RelationDefs extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			relations() { return $this->__call("relations"); }
};


?>
