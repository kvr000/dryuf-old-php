<?php

namespace net\dryuf\mvp\proc;


class SubdomRedirectPresenter extends \net\dryuf\mvp\ChildPresenter
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
		$rootPresenter = $this->getRootPresenter();
		$rootPresenter->getPathElement();
		$remainPath = strval(substr($rootPresenter->getRequest()->getUri(), strlen($rootPresenter->getCurrentPath())));
		$rootPresenter->getResponse()->redirect($remainPath);
		return false;
	}
};


?>
