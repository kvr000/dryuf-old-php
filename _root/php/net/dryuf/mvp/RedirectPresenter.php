<?php

namespace net\dryuf\mvp;


class RedirectPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($presenter, $options)
	{
		parent::__construct($presenter, $options);
		$this->redirect = $options->getOptionMandatory("redirect");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$this->getRootPresenter()->redirect(\net\dryuf\srvui\PageUrl::createFinal($this->redirect));
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$redirect;
};


?>
