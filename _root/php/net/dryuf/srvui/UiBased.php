<?php

namespace net\dryuf\srvui;


class UiBased extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($callerContext)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
		$this->uiContext = $callerContext->getUiContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	protected			$uiContext;
};


?>
