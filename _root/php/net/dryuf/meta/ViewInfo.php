<?php

namespace net\dryuf\meta;


class ViewInfo extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			name() { return $this->__call("name"); }
	public function			renderer() { return $this->__call("renderer"); }
	public function			supplier() { return $this->__call("supplier"); }
	public function			clientClass() { return $this->__call("clientClass"); }
	public function			fields() { return $this->__call("fields"); }
	public function			actions() { return $this->__call("actions"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'renderer'			 => "",
				'supplier'			 => "",
				'clientClass'			 => "",
				'fields'			 => array( "" ),
				'actions'			 => array( "" ),
			),
			$args
		));
	}

};


?>
