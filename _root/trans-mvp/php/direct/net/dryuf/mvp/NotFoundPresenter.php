<?php

namespace net\dryuf\mvp;


class NotFoundPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->getResponse()->sendError(404, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->output("Page not found");
	}
};


?>
