<?php

#
# Dryuf framework
#
# ----------------------------------------------------------------------------------
#
# Copyright (C) 2000-2015 Zbyněk Vyškovský
#
# ----------------------------------------------------------------------------------
#
# LICENSE:
#
# This file is part of Dryuf
#
# Dryuf is free software; you can redistribute it and/or modify it under the
# terms of the GNU Lesser General Public License as published by the Free
# Software Foundation; either version 3 of the License, or (at your option)
# any later version.
#
# Dryuf is distributed in the hope that it will be useful, but WITHOUT ANY
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
# FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for
# more details.
#
# You should have received a copy of the GNU Lesser General Public License
# along with Dryuf; if not, write to the Free Software Foundation, Inc., 51
# Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#
# @author	2000-2015 Zbyněk Vyškovský
# @link		mailto:kvr@matfyz.cz
# @link		http://kvr.matfyz.cz/software/java/dryuf/
# @link		http://github.com/dryuf/
# @license	http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License v3
#

namespace net\dryuf\security\web\php;


class PhpAuthenticationFrontend extends \net\dryuf\core\Object implements \net\dryuf\security\web\AuthenticationFrontend
{
	/**
	*/
	public function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = "net\dryuf\security\bo\UserAccountBo")
	@\javax\inject\Inject
	*/
	protected			$userAccountBo;

	/**
	@\net\dryuf\core\Type(type = "net\dryuf\core\AppContainer")
	@\javax\inject\Inject
	*/
	protected			$appContainer;

	/**
	@\net\dryuf\core\Type(type = "int")
	*/
	public function			authenticateUserPassword(\net\dryuf\srvui\PageContext $pageContext, $username, $password)
	{
		global $_SESSION;
		$userAccount = new \net\dryuf\security\UserAccount();
		$userAccount->setUsername($username);
		$userAccount->setPassword($password);
		$roles = new \net\dryuf\util\HashSet();
		$err = $this->userAccountBo->login($userAccount, $roles, $pageContext->getSession()->getSessionId(), $pageContext->getRequest()->getRemoteHost());
		if ($err == 0) {
			$session = $pageContext->forceSession();
			$_SESSION['net.dryuf.core.CallerContext.userId'] = $userAccount->getUserId();
			$_SESSION['net.dryuf.core.CallerContext.roles'] = $roles->toArray();
		}
		return $err;
	}

	/**
	@\net\dryuf\core\Type(type = "net\dryuf\core\CallerContext")
	*/
	public function			initCallerContext(\net\dryuf\srvui\Request $request)
	{
		session_start();
		return \net\dryuf\core\srvui\PhpCallerContext::createFromSession($this->appContainer);
	}

	/**
	@\net\dryuf\core\Type(type = "void")
	*/
	public function			logout(\net\dryuf\srvui\PageContext $pageContext)
	{
		if (!is_null(($session = $pageContext->getSession())))	
			$session->invalidate();
		$pageContext->getCallerContext()->loggedOut();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEffectiveUserId(\net\dryuf\srvui\PageContext $pageContext, $userId)
	{
		$pageContext->getSession()->setAttribute('net.dryuf.core.CallerContext'.".effectiveUserId", $userId);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			resetRoles(\net\dryuf\srvui\PageContext $pageContext, $newRoles)
	{
		$pageContext->getSession()->setAttribute('net.dryuf.core.CallerContext.roles', $newRoles->toArray());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTranslationLevel(\net\dryuf\srvui\PageContext $pageContext, $translationLevel)
	{
		$pageContext->getSession()->setAttribute('net.dryuf.core.UiContext'.".translationLevel", $translationLevel);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTiming(\net\dryuf\srvui\PageContext $pageContext, $timing)
	{
		$pageContext->getSession()->setAttribute('net.dryuf.core.UiContext'.".timing", $timing);
	}
};


?>
