<?php

namespace net\dryuf\mvp;


class DeniedPresenter extends \net\dryuf\mvp\ErrorPresenter
{
	/**
	*/
	function			__construct(\net\dryuf\mvp\Presenter $parentPresenter, \net\dryuf\core\Options $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->content = "Unauthorized access";
		$this->getResponse()->sendError(401, "Unauthorized access");
	}
};


?>
