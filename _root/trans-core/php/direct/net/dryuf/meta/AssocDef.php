<?php

namespace net\dryuf\meta;


class AssocDef extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			assocType() { return $this->__call("assocType"); }
	public function			target() { return $this->__call("target"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'assocType'			 => \net\dryuf\app\FieldDef::AST_None,
				'target'			 => 'void',
			),
			$args
		));
	}

};


?>
