<?php

namespace net\dryuf\mvp;


class WrapCallerContextPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->setCallerContext(\net\dryuf\core\RoleContext::createMapped($parentPresenter->getCallerContext(), $options->getOptionMandatory("rolesMapping")));
		$this->subPresenter = $options->getOptionDefault("subPresenter", null);
		$this->subOptions = $options->getOptionDefault("subOptions", \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		if (!is_null($this->subPresenter)) {
			\net\dryuf\mvp\Presenter::createSubPresenter($this->subPresenter, $this, $this->subOptions);
		}
		return parent::process();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\mvp\Presenter>')
	*/
	public				$subPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public				$subOptions;
};


?>
