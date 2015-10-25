<?php

namespace net\dryuf\core\test;


/**
@\java\lang\annotation\Inherited
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::TYPE,
	\java\lang\annotation\ElementType::METHOD,
	\java\lang\annotation\ElementType::FIELD
})
*/
class TestAnnotationTwo extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			value() { return $this->__call("value"); }
};


?>
