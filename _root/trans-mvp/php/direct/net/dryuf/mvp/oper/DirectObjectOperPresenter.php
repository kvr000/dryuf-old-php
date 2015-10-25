<?php

namespace net\dryuf\mvp\oper;


class DirectObjectOperPresenter extends \net\dryuf\mvp\oper\ObjectOperPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $rootController, $ownerHolder)
	{
		parent::__construct($parentPresenter, $options, $rootController);
		$this->ownerHolder = $ownerHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected function		getOwnerHolder()
	{
		return $this->ownerHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected			$ownerHolder;
};


?>
