<?php

namespace net\dryuf\mvp;


class DummyPresenter extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	*/
	function			__construct()
	{
		parent::__construct(null, \net\dryuf\core\Options::$NONE);
	}

	/**
	*/
	function			__construct($parentPresenter_)
	{
		parent::__construct($parentPresenter_, \net\dryuf\core\Options::$NONE);
	}

	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		parent::__construct($parentPresenter_, $options);
	}
};


?>
