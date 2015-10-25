<?php

namespace net\dryuf\mvp;


class IndexPagePresenter extends \net\dryuf\mvp\StaticPagePresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, \net\dryuf\core\Options::buildListed("page", "index"));
	}
};


?>
