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
namespace net\dryuf\srvui\php;


class PhpCallerContext implements \net\dryuf\core\CallerContext
{
	static function			createFromSession($appContainer)
	{
		global $_SESSION;

		$self = new self($appContainer);
		$self->initFromSession();

		return $self;
	}

	function			__construct(\net\dryuf\core\AppContainer $appContainer)
	{
		$this->appContainer = $appContainer;
		$this->workRoot = $appContainer->getWorkRoot();
		$this->appRoot = $appContainer->getAppRoot();
		$this->roles = array('guest' => 1, '' => 1);
		$this->userId = null;
		$this->uiContext = new \net\dryuf\srvui\php\PhpSrvUiContext($this);
	}

	function			getWorkRoot()
	{
		return $this->workRoot;
	}

	function			getAppRoot()
	{
		return $this->appRoot;
	}

	function			getRootContext()
	{
		return $this;
	}

	function			checkRole($roles)
	{
		if ($roles == "")
			return true;
		foreach (explode(',', $roles) as $r) {
			if (array_key_exists($r, $this->roles))
				return true;
		}
		return false;
	}

	function			getRoles()
	{
		$set = new \net\dryuf\util\php\NativeHashSet();
		foreach ($this->roles as $k => $v)
			$set->add($k);
		return $set;
	}

	function			getRoleHash()
	{
		if (!isset($this->role_hash))
			$this->role_hash = sprintf("%04.4x", crc32(join(",", array_keys($this->roles))));
		return $this->role_hash;
	}

	function			getContextVar($name)
	{
		if ($name == 'userId')
			return $this->getUserId();
		else
			throw new \net\dryuf\core\Exception("invalid system bind $name");
	}

	function			isLoggedIn()
	{
		return !is_null($this->userId);
	}

	function			getUserId()
	{
		return $this->userId;
	}

	function			getRealUserId()
	{
		return $this->realUserId;
	}

	function			getUserInfo()
	{
		return array("userId" => $this->getUserId());
	}

	function			initFromSession()
	{
		global $_SESSION;
		if (!isset($_SESSION['net.dryuf.core.CallerContext.userId'])) {
			$this->realId = null;
			$this->userId = null;
			$this->roles = array('guest' => 1);
		}
		else {
			$this->realId = $_SESSION['net.dryuf.core.CallerContext.userId'];
			$this->userId = $_SESSION['net.dryuf.core.CallerContext.userId'];
			if (isset($_SESSION['net.dryuf.core.CallerContext.effectiveUserId'])) {
				$this->userId = $_SESSION['net.dryuf.core.CallerContext.effectiveUserId'];
			}
			$this->roles = array_fill_keys($_SESSION['net.dryuf.core.CallerContext.roles'], 1);
		}
		if (isset($_SESSION['net.dryuf.core.UiContext'.".translationLevel"])) {
			$this->getUiContext()->setLocalizeDebug($_SESSION['net.dryuf.core.UiContext'.".translationLevel"]);
		}
		if (isset($_SESSION['net.dryuf.core.UiContext'.".timing"])) {
			$this->getUiContext()->setTiming($_SESSION['net.dryuf.core.UiContext'.".timing"]);
		}
	}

	function			loggedOut()
	{
		$this->roles = array_fill_keys(array("", "guest"), 1);
		$this->userId = null;
	}

	function			setEffectiveUser($userId)
	{
		$_SESSION['userId'] = $this->userId = $userId;
	}

	function			getConfig()
	{
		return \net\dryuf\core\Dryuf::$config;
	}

	function			getConfigValue($name, $def_value = null)
	{
		if (!isset($this->config[$name])) {
			$sub_conf = $this->getConfig();
			if (isset($sub_conf[$name])) {
				$sub_conf = $sub_conf[$name];
			}
			else {
				foreach (preg_split(',[/.],', $name) as $subname) {
					if (!isset($sub_conf[$subname])) {
						$sub_conf = $def_value;
						break;
					}
					else {
						$sub_conf = $sub_conf[$subname];
					}
				}
			}
			$this->config[$name] = $sub_conf;
		}
		return $this->config[$name];
	}

	function			createBeaned($name, $injects)
	{
		$obj = \net\dryuf\core\Dryuf::createClassArg0($name);
		return $this->appContainer->postProcessBean($obj, null, $injects);
	}

	function			createBeanedArgs($name, $args, $injects)
	{
		$func = "createClassArg".count($args);
		$obj = call_user_func_array(array('net\dryuf\core\Dryuf', $func), array_merge(array($name), $args));
		return $this->appContainer->postProcessBean($obj, null, $injects);
	}

	function			createFullContext()
	{
		$full = new self();
		return $full;
	}

	public function			close()
	{
		foreach ($this->handlers as $handler) {
			try {
				$handler->close();
			}
			catch (\Exception $ex) {
			}
		}
	}

	public function			checkResource($identifier)
	{
		return isset($this->handlers[$identifier]) ? $this->handlers[$identifier] : null;
	}

	public function			saveResource($identifier, $handler)
	{
		$this->handlers[$identifier] = $handler;
	}

	function			getClasspathResourceAsStream($filename)
	{
		return fopen($this->workRoot.$filename);
	}

	function			getBean($name)
	{
		return $this->appContainer->getBean($name);
	}

	function			getBeanTyped($name, $clazz)
	{
		return $this->appContainer->getBeanTyped($name, $clazz);
	}

	function			getBeanContext()
	{
		return null;
	}

	function			getUiContext()
	{
		return $this->uiContext;
	}

	function			getAppContainer()
	{
		return $this->appContainer;
	}

	public				$appContainer;

	public				$workRoot;
	public				$appRoot;

	public				$roles;
	public				$role_hash;
	public				$userId = null;
	public				$realUserId = null;

	public				$config;
	public				$uiContext;

	protected			$handlers = array();
}


?>
