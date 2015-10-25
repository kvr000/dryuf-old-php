<?php

namespace net\dryuf\security\mvp;


class ForgotUpdatePasswordOkPresenter extends \net\dryuf\mvp\StaticPagePresenter
{
	/**
	*/
	function			__construct($presenter, $options)
	{
		parent::__construct($presenter, $options->cloneAddingListed("page", "forgotupdatepasswordok"));
	}
};


?>
