<?php

namespace net\dryuf\security\mvp;


class CommonLoggedPresenter extends \net\dryuf\security\mvp\LoggedPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		parent::render();
	}
};


?>
