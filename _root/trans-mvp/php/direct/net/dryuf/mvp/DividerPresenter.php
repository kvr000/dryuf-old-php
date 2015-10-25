<?php

namespace net\dryuf\mvp;


class DividerPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $presenterDivider)
	{
		parent::__construct($parentPresenter, $options);
		$this->presenterDivider = $presenterDivider;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return $this->presenterDivider->process($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	protected			$presenterDivider;
};


?>
