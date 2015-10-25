<?php

namespace net\dryuf\dao;


abstract class DaoContextBase extends \net\dryuf\core\Object implements \net\dryuf\dao\DynamicDao
{
	/**
	*/
	function			__construct($entityClass)
	{
		parent::__construct();
		$this->entityClass = $entityClass;
		if (is_null($this->entityClass))
			return;
		$this->pkName = $this->resolvePkField();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		resolvePkField()
	{
		foreach ((=f_I_x=)entityClass.getFields()(=x_I_f=) as $field) {
			if (!is_null((=f_I_x=)field.getAnnotation(Id.class)(=x_I_f=)) || !is_null((=f_I_x=)field.getAnnotation(EmbeddedId.class)(=x_I_f=))) {
				$this->pkName = (=f_I_x=)field.getName()(=x_I_f=);
				$this->pkClass = (=f_I_x=)field.getType()(=x_I_f=);
			}
		}
		foreach ((=f_I_x=)entityClass.getMethods()(=x_I_f=) as $method) {
			if (substr((=f_I_x=)method.getName()(=x_I_f=), 0, strlen("get")) == "get" && (!is_null((=f_I_x=)method.getAnnotation(Id.class)(=x_I_f=)) || !is_null((=f_I_x=)method.getAnnotation(EmbeddedId.class)(=x_I_f=)))) {
				$this->pkName = (=f_I_x=)method.getName()(=x_I_f=);
				$this->pkName = strtolower(strval(substr($this->pkName, 0, 1))).strval(substr($this->pkName, 1));
				$this->pkClass = (=f_I_x=)method.getReturnType()(=x_I_f=);
			}
		}
		for ($clazz = $this->entityClass; is_null($this->pkName) && !is_null($clazz); $clazz = (=f_I_x=)clazz.getSuperclass()(=x_I_f=)) {
			foreach ((=f_I_x=)entityClass.getDeclaredFields()(=x_I_f=) as $field) {
				if (!is_null((=f_I_x=)field.getAnnotation(Id.class)(=x_I_f=)) || !is_null((=f_I_x=)field.getAnnotation(EmbeddedId.class)(=x_I_f=))) {
					$this->pkName = (=f_I_x=)field.getName()(=x_I_f=);
					$this->pkClass = (=f_I_x=)field.getType()(=x_I_f=);
				}
			}
		}
		if (is_null($this->pkName))
			throw new \net\dryuf\core\RuntimeException("cannot find primary key in class ".$this->entityClass);
		return $this->pkName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	*/
	public function			refresh($obj)
	{
		$this->entityManager->refresh($obj);
		return $obj;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	*/
	public function			loadByPk($pk)
	{
		return $this->entityManager->find($this->entityClass, $pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Object>')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	*/
	public function			listAll()
	{
		return $this->entityManager->createQuery("SELECT ent FROM ".\net\dryuf\core\Dryuf::dotClassname($this->entityClass)." ent ORDER BY ".$this->pkName)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			insert($obj)
	{
		$this->entityManager->persist($obj);
		$this->entityManager->flush();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			insertTxNew($obj)
	{
		$this->runTransactionedNewSafe(
			function () use ($obj) {
				$this->entityManager->persist($obj);
				$this->entityManager->flush();
				return false;
			}
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			update($obj)
	{
		$obj = $this->entityManager->merge($obj);
		$this->entityManager->flush();
		return $obj;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			remove($obj)
	{
		$this->entityManager->remove($obj);
		$this->entityManager->flush();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByPk($pk)
	{
		return $this->entityManager->createQuery("DELETE FROM ".\net\dryuf\core\Dryuf::dotClassname($this->entityClass)." obj WHERE obj.".$this->pkName." = ?1")->setParameter(1, $pk)->executeUpdate() != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			openRelation($holder, $relation)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("openRelation not supported yet");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			importDynamicKey($data)
	{
		return $this->getRoleDaoAccess()->importDynamicKey($data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			exportDynamicData($holder)
	{
		return $this->getRoleDaoAccess()->exportDynamicData($holder);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			exportEntityData($holder)
	{
		return $this->getRoleDaoAccess()->exportEntityData($holder);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			createDynamic($composition, $data)
	{
		return $this->getRoleDaoAccess()->createObject($composition, $data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			retrieveDynamic($composition, $pk)
	{
		return $this->getRoleDaoAccess()->retrieveObject($composition, $pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			updateDynamic($roleObject, $pk, $updates)
	{
		return $this->getRoleDaoAccess()->updateObject($roleObject, $pk, $updates);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			deleteDynamic($composition, $pk)
	{
		return $this->getRoleDaoAccess()->deleteObject($composition, $pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			listDynamic($results, $composition, $filter, $sorts, $start, $limit)
	{
		return $this->getRoleDaoAccess()->listObjects($results, $composition, $filter, $sorts, $start, $limit);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\transaction\TransactionHandler')
	*/
	public function			keepContextTransaction($callerContext)
	{
		return $this->transactionManager->keepContextTransaction($callerContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			runTransactionedNew($code)
	{
		$transaction = $this->transactionManager->openTransaction(false);
		try {
			$ret = call_user_func($code);
			$transaction->commit();
			return $ret;
		}
		catch (\net\dryuf\core\Exception $ex) {
			$transaction->close();
			throw $ex;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			runTransactionedNewSafe($code)
	{
		$transaction = $this->transactionManager->openTransaction(false);
		try {
			$ret = call_user_func($code);
			$transaction->commit();
			return $ret;
		}
		catch (\net\dryuf\core\RuntimeException $ex) {
			$transaction->close();
			throw $ex;
		}
		catch (\net\dryuf\core\Exception $ex) {
			$transaction->close();
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\RoleDaoAccessJpa<java\lang\Object, java\lang\Object>')
	*/
	protected function		getRoleDaoAccess()
	{
		return $this->roleDaoAccess;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		setEntityManagerInternal($entityManager)
	{
		$this->entityManager = $entityManager;
		$this->roleDaoAccess = new \net\dryuf\dao\RoleDaoAccessJpa($this->entityClass, $entityManager);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		setTransactionManagerInternal($transactionManager)
	{
		$this->transactionManager = $transactionManager;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\transaction\TransactionManager')
	*/
	protected			$transactionManager;

	/**
	@\net\dryuf\core\Type(type = 'javax\persistence\EntityManager')
	*/
	protected			$entityManager;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$entityClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getEntityClass()
	{
		return $this->entityClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$pkClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$pkName;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\RoleDaoAccessJpa<java\lang\Object, java\lang\Object>')
	*/
	protected			$roleDaoAccess;
};


?>
