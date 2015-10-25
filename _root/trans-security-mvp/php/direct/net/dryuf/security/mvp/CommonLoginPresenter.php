<?php

namespace net\dryuf\security\mvp;


class CommonLoginPresenter extends \net\dryuf\security\mvp\LoginPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->authenticationFrontend = $this->getCallerContext()->getBeanTyped("authenticationFrontend", 'net\dryuf\security\web\AuthenticationFrontend');
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			doLogin()
	{
		$loginForm = $this->backingObject;
		$err = $this->authenticationFrontend->authenticateUserPassword($this->getPageContext(), $loginForm->getUsername(), $loginForm->getPassword());
		switch ($err) {
		case \net\dryuf\security\bo\UserAccountBo::ERR_Ok:
			$this->getRootPresenter()->getResponse()->redirect(!is_null($loginForm->getRedir()) ? $loginForm->getRedir() : "../logged/");
			return null;

		case \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount:
			return $this->localize('net\dryuf\security\bo\UserAccountBo', "Unknown user");

		case \net\dryuf\security\bo\UserAccountBo::ERR_WrongPassword:
			return $this->localize('net\dryuf\security\bo\UserAccountBo', "Wrong password");

		case \net\dryuf\security\bo\UserAccountBo::ERR_AccountUnactivated:
			return $this->localize('net\dryuf\security\bo\UserAccountBo', "User not activated");

		case \net\dryuf\security\bo\UserAccountBo::ERR_AccountExpired:
			return $this->localize('net\dryuf\security\bo\UserAccountBo', "Account expired");

		default:
			return $this->localizeArgs(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\security\bo\UserAccountBo'), "Unknown error: {0}", 
				array(
					$err
				));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\web\AuthenticationFrontend')
	*/
	protected			$authenticationFrontend;
};


?>
