<?php

namespace net\dryuf\security\dao;


class UserAccountRoleProcessor extends \net\dryuf\dao\AbstractRoleProcessor
{
	/**
	*/
	function			__construct($baseContext, $clazz)
	{
		parent::__construct($baseContext, $clazz);
		$this->isUserview = $baseContext->checkRole("userview");
		$this->isAdmin = $baseContext->checkRole("admin");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			modifyQuery($query)
	{
		if ($this->isUserview) {
			$query->appendColumns(self::$adminAppendedColumns);
		}
		elseif ($this->isAdmin) {
			$query->appendColumns(self::$adminAppendedColumns);
			$query->appendWhere(" AND ent.userId = ?");
			$query->appendWhereBind($this->callerContext->getContextVar("userId"));
		}
		else {
			$query->appendColumns(self::$appendedColumns);
			$query->appendWhere(" AND ent.userId = ?");
			$query->appendWhereBind($this->callerContext->getContextVar("userId"));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\security\UserAccount>')
	*/
	public function			createEntityFromResult($result)
	{
		$entity = $result;
		$newContext = new \net\dryuf\core\RoleContext($this->callerContext);
		$newContext->getRoles()->add("UserAccount.read");
		if (($entity->getUserId() === $this->callerContext->getUserId()) && $this->callerContext->checkRole("free")) {
			$newContext->getRoles()->add("UserAccount.update");
		}
		if ($this->isAdmin) {
			$newContext->getRoles()->add("UserAccount.update");
			$newContext->getRoles()->add("UserAccount.admin");
		}
		return new \net\dryuf\core\EntityHolder($entity, $newContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isUserview = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isAdmin = false;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	static				$appendedColumns;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	static				$adminAppendedColumns;

	public static function		_initManualStatic()
	{
		self::$appendedColumns = new \net\dryuf\util\LinkedList();
		{
		}
		self::$adminAppendedColumns = new \net\dryuf\util\LinkedList();
		{
		}
	}

};

\net\dryuf\security\dao\UserAccountRoleProcessor::_initManualStatic();


?>
