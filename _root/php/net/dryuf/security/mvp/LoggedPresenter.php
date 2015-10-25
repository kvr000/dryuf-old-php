<?php

namespace net\dryuf\security\mvp;


class LoggedPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		parent::__construct($parentPresenter_, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		parent::render();
		$this->outputFormat("%W<p/>", 'net\dryuf\security\mvp\LoggedPresenter', "You have been successfully logged in.");
		$this->outputFormat("<a href=\"%U\">%W</a><p/>", \net\dryuf\srvui\PageUrl::createPaged("changepassword"), 'net\dryuf\security\mvp\LoggedPresenter', "You can change password here.");
	}
};


?>
