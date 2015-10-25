<?php

namespace net\dryuf\meta;


/**
@\java\lang\annotation\Target(value = { })
*/
class RelationDef extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			name() { return $this->__call("name"); }
	public function			targetClass() { return $this->__call("targetClass"); }
};


?>
