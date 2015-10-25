<?php

namespace net\dryuf\mvp\oper;


class ClassObjectOperPresenter extends \net\dryuf\mvp\oper\ObjectOperPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options, $parentPresenter->getCallerContext()->getBeanTyped("appRootOper", 'net\dryuf\oper\ObjectOperController'));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected function		getOwnerHolder()
	{
		return \net\dryuf\core\EntityHolder::createRoleOnly($this->getCallerContext());
	}
};


?>
