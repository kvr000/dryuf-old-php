<?php

namespace net\dryuf\mvp\oper;


abstract class ObjectOperPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $rootController)
	{
		parent::__construct($parentPresenter, $options);
		\net\dryuf\core\Dryuf::assertNotNull($rootController);
		$this->rootController = $rootController;
		$this->getRootPresenter()->setLeadChild($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return (new \net\dryuf\oper\ObjectOperContext($this->getPageContext(), $this->rootController, $this->getOwnerHolder()))->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected abstract function	getOwnerHolder();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController<java\lang\Object>')
	*/
	protected			$rootController;
};


?>
