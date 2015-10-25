<?php

namespace net\dryuf\meta;


/**
@\java\lang\annotation\Target(value = {
	\java\lang\annotation\ElementType::TYPE,
	\java\lang\annotation\ElementType::FIELD
})
*/
class FieldRoles extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			roleNew() { return $this->__call("roleNew"); }
	public function			roleSet() { return $this->__call("roleSet"); }
	public function			roleGet() { return $this->__call("roleGet"); }
	public function			roleDel() { return $this->__call("roleDel"); }
};


?>
