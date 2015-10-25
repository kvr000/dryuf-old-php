<?php

namespace net\dryuf\mvp;


class LeadChildPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$parentPresenter->setLeadChild($this);
	}
};


?>
