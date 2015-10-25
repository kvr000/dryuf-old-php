<?php

namespace net\dryuf\meta;


class PKeyDef extends \net\dryuf\core\php\PhpAnnotationBase 
{
	public function			pkEmbedded() { return $this->__call("pkEmbedded"); }
	public function			pkClazz() { return $this->__call("pkClazz"); }
	public function			pkField() { return $this->__call("pkField"); }
	public function			composClazz() { return $this->__call("composClazz"); }
	public function			composPkClazz() { return $this->__call("composPkClazz"); }
	public function			composPath() { return $this->__call("composPath"); }
	public function			additionalPkFields() { return $this->__call("additionalPkFields"); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'composClazz'			 => 'void',
				'composPkClazz'			 => 'void',
				'composPath'			 => "",
			),
			$args
		));
	}

};


?>
