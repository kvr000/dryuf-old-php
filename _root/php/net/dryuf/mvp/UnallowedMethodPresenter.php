<?php

namespace net\dryuf\mvp;


class UnallowedMethodPresenter extends \net\dryuf\mvp\ErrorPresenter
{
	/**
	*/
	function			__construct(\net\dryuf\mvp\Presenter $parentPresenter, \net\dryuf\core\Options $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->content = $options->getOptionDefault("content", "The requested method ".$this->getRootPresenter()->getRequest()->getMethod()." is not allowed for this URL.");
		$this->getResponse()->sendError(405, "Method Not Allowed");
	}
};


?>
