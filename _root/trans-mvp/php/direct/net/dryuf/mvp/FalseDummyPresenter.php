<?php

namespace net\dryuf\mvp;


class FalseDummyPresenter extends \net\dryuf\mvp\BoolDummyPresenter
{
	/**
	*/
	function			__construct($parentPresenter_)
	{
		parent::__construct($parentPresenter_, false);
	}
};


?>
