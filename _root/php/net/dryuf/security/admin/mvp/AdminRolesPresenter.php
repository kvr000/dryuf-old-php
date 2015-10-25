<?php

namespace net\dryuf\security\admin\mvp;


class AdminRolesPresenter extends \net\dryuf\mvp\MappedFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		$this->userAccountBo = $this->getCallerContext()->getBeanTyped("userAccountBo", 'net\dryuf\security\bo\UserAccountBo');
		$this->authenticationFrontend = $this->callerContext->getBeanTyped("authenticationFrontend", 'net\dryuf\security\web\AuthenticationFrontend');
		return parent::processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setBackingObject($backingObject)
	{
		parent::setBackingObject($backingObject);
		foreach ($this->getCallerContext()->getAppContainer()->getGlobalRoles() as $roleName) {
			$backingObject->put("role_".$roleName, $this->getCallerContext()->checkRole($roleName));
		}
		$backingObject->put("translationLevel", $this->getUiContext()->getLocalizeDebug());
		$backingObject->put("timing", $this->getUiContext()->getTiming());
		$backingObject->put("effectiveUserId", null);
		$backingObject->put("effectiveUserName", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\app\FieldDef<java\lang\Object>>')
	*/
	public function			buildDisplayableFields()
	{
		$fields = new \net\dryuf\util\LinkedList();
		foreach ($this->getCallerContext()->getAppContainer()->getGlobalRoles() as $roleName) {
			$fields->add((new \net\dryuf\app\FieldDefImpl())->setName("role_".$roleName)->setDisplay("checkbox()")->setMandatory(true)->setDoMandatory(false)->setTextual('net\dryuf\textual\BoolSwitchTextual')->setRoles(new \net\dryuf\app\FieldRolesImpl($this->checkRoleDependency($roleName) ? "" : "denied", null, "", null)));
		}
		$fields->add((new \net\dryuf\app\FieldDefImpl())->setName("translationLevel")->setDisplay("select(120px, none^missing^all)")->setMandatory(true)->setTextual('net\dryuf\textual\NaturalTextual')->setRoles(new \net\dryuf\app\FieldRolesImpl("translation", null, "", null)));
		$fields->add((new \net\dryuf\app\FieldDefImpl())->setName("timing")->setDisplay("checkbox()")->setMandatory(true)->setDoMandatory(false)->setTextual('net\dryuf\textual\BoolSwitchTextual')->setRoles(new \net\dryuf\app\FieldRolesImpl("timing", null, "", null)));
		$fields->add((new \net\dryuf\app\FieldDefImpl())->setName("effectiveUserId")->setDisplay("text(120px)")->setMandatory(false)->setTextual('net\dryuf\textual\NaturalLongTextual')->setRoles(new \net\dryuf\app\FieldRolesImpl("swapuser", null, "", null)));
		$fields->add((new \net\dryuf\app\FieldDefImpl())->setName("effectiveUserName")->setDisplay("text(120px)")->setMandatory(false)->setTextual('net\dryuf\textual\LineTrimTextual')->setRoles(new \net\dryuf\app\FieldRolesImpl("swapuser", null, "", null)));
		return $fields;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	private function		checkRoleDependency($roleName)
	{
		$container = $this->getCallerContext()->getAppContainer();
		foreach ($container->checkRoleDependency($roleName) as $dependent) {
			if ($this->getCallerContext()->checkRole($dependent))
				return true;
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			formOutputType($fdef, $d_type, $d_args, $formatted)
	{
		parent::formOutputType($fdef, $d_type, $d_args, $formatted);
		switch ($fdef->getName()) {
		case "effectiveUserId":
			$this->outputFormat(" (%S)", $this->getCallerContext()->getUserId());
			break;

		case "effectiveUserName":
			$userAccount = $this->userAccountBo->load($this->getCallerContext()->getUserId());
			$this->outputFormat(" (%S)", is_null($userAccount) ? "unknown" : $userAccount->getUsername());
			break;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			retrieve($errors, $action)
	{
		if (!parent::retrieve($errors, $action))
			return false;
		if (!is_null($this->backingObject->get("effectiveUserId"))) {
			$this->newUserAccount = $this->userAccountBo->load($this->backingObject->get("effectiveUserId"));
			if (!is_null($this->newUserAccount)) {
			}
			else {
				$errors->put("effectiveUserId", $this->localize('net\dryuf\security\admin\mvp\AdminRolesPresenter', "Invalid user ID"));
			}
		}
		elseif (!is_null($this->backingObject->get("effectiveUserName"))) {
			$this->newUserAccount = $this->userAccountBo->loadByUsername($this->backingObject->get("effectiveUserName"));
			if (!is_null($this->newUserAccount)) {
				$this->authenticationFrontend->setEffectiveUserId($this->getPageContext(), $this->newUserAccount->getUserId());
			}
			else {
				$errors->put("effectiveUserId", $this->localize('net\dryuf\security\admin\mvp\AdminRolesPresenter', "Invalid user name"));
			}
		}
		return $errors->size() == 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performSubmit($action)
	{
		$callerContext = $this->getCallerContext();
		$newRoles = new \net\dryuf\util\php\StringNativeHashSet();
		foreach ($callerContext->getAppContainer()->getGlobalRoles() as $roleName) {
			if ($this->backingObject->get("role_".$roleName))
				$newRoles->add($roleName);
		}
		$this->authenticationFrontend->resetRoles($this->getPageContext(), $newRoles);
		$this->authenticationFrontend->setTranslationLevel($this->getPageContext(), $this->backingObject->get("translationLevel"));
		$this->authenticationFrontend->setTiming($this->getPageContext(), $this->backingObject->get("timing"));
		if (!is_null($this->newUserAccount))
			$this->authenticationFrontend->setEffectiveUserId($this->getPageContext(), $this->newUserAccount->getUserId());
		$this->getResponse()->redirect(".");
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->output("<h3>Current global roles:</h3><br/>");
		parent::render();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	*/
	protected			$userAccountBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\web\AuthenticationFrontend')
	*/
	protected			$authenticationFrontend;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	*/
	protected			$newUserAccount;
};


?>
