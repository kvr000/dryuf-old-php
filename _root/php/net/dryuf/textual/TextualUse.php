<?php

namespace net\dryuf\textual;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::FIELD
})
*/
class TextualUse extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			textual() { return $this->__call("textual"); }
};


?>
