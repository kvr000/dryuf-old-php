<?php

namespace net\dryuf\mvp;


class DividerDefaultToResourcesPresenter extends \net\dryuf\mvp\ChildPresenter
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
		if (!is_null(($childPresenter = $this->presenterDivider->tryPage($this))))
			return $childPresenter->process();
		$this->getRootPresenter()->putBackLastElement();
		return (new \net\dryuf\mvp\proc\ResourcesPresenter($this, \net\dryuf\core\Options::$NONE))->init()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	protected			$presenterDivider;
};


?>
