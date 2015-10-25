<?php

namespace net\dryuf\meta;


class ReferenceDef extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			basePath() { return $this->__call("basePath"); }
	public function			loadAction() { return $this->__call("loadAction"); }
	public function			listAllAction() { return $this->__call("listAllAction"); }
	public function			listNewAction() { return $this->__call("listNewAction"); }
	public function			listSetAction() { return $this->__call("listSetAction"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'basePath'			 => "",
				'loadAction'			 => "",
				'listAllAction'			 => "",
				'listNewAction'			 => "",
				'listSetAction'			 => "",
			),
			$args
		));
	}

};


?>
