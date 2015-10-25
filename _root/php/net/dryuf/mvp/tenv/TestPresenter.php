<?php

namespace net\dryuf\mvp\tenv;


class TestPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				PS_Std = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				PS_NotFound = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				PS_Denied = 2;

	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		$this->state = self::PS_Std;

		parent::__construct($parentPresenter_, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createNotFoundPresenter()
	{
		$this->state = self::PS_NotFound;
		return new \net\dryuf\mvp\NotFoundPresenter($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDeniedPresenter()
	{
		$this->state = self::PS_Denied;
		return new \net\dryuf\mvp\DeniedPresenter($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getState()
	{
		return $this->state;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$state;
};


?>
