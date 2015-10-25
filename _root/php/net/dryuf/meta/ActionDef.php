<?php

namespace net\dryuf\meta;


class ActionDef extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			name() { return $this->__call("name"); }
	public function			isStatic() { return $this->__call("isStatic"); }
	public function			guiDef() { return $this->__call("guiDef"); }
	public function			formName() { return $this->__call("formName"); }
	public function			formActioner() { return $this->__call("formActioner"); }
	public function			reqMode() { return $this->__call("reqMode"); }
	public function			roleAction() { return $this->__call("roleAction"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'name'				 => "",
				'guiDef'			 => "",
				'formName'			 => "",
				'formActioner'			 => "",
				'reqMode'			 => "",
				'roleAction'			 => "",
			),
			$args
		));
	}

};


?>
