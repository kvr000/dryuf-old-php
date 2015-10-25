<?php

namespace net\dryuf\security\mvp;


class CommonLogoutPresenter extends \net\dryuf\security\mvp\LogoutPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->authenticationFrontend = $this->getCallerContext()->getBeanTyped("authenticationFrontend", 'net\dryuf\security\web\AuthenticationFrontend');
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			doLogout()
	{
		$this->authenticationFrontend->logout($this->getPageContext());
		$this->getCallerContext()->loggedOut();
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\web\AuthenticationFrontend')
	*/
	protected			$authenticationFrontend;
};


?>
