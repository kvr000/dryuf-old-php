<?php

namespace net\dryuf\mvp\oper;


class BeanObjectOperPresenter extends \net\dryuf\mvp\oper\DirectObjectOperPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $operName, $ownerHolder)
	{
		parent::__construct($parentPresenter, $options, $parentPresenter->getCallerContext()->getBeanTyped($operName, 'net\dryuf\oper\ObjectOperController'), $ownerHolder);
		$this->ownerHolder = $ownerHolder;
	}
};


?>
