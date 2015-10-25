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
		foreach (\net\dryuf\core\Dryuf::listFieldsByAnnotation($this->entityClass, 'javax\persistence\Id') as $fieldName => $anno) {
			$this->pkClass = \net\dryuf\core\Dryuf::getFieldType($this->entityClass, $fieldName);
			return $fieldName;
		}
		foreach (\net\dryuf\core\Dryuf::listFieldsByAnnotation($this->entityClass, 'javax\persistence\EmbeddedId') as $fieldName => $anno) {
			$this->pkClass = \net\dryuf\core\Dryuf::getFieldType($this->entityClass, $fieldName);
			return $fieldName;
		}
		foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($this->entityClass, 'javax\persistence\Id') as $methodName => $anno) {
			$prefix = substr($methodName, 0, 3);
			if ($prefix != "get" && $prefix != "set")
				throw new \net\dryuf\core\RuntimeException("method $this->entityClass.$methodName does not start with get/set");
			$this->pkClass = \net\dryuf\core\Dryuf::getMethodReturnType($this->entityClass, $methodName);
			return lcfirst(substr($methodName, 3));
		}
		foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($this->entityClass, 'javax\persistence\EmbeddedId') as $methodName => $anno) {
			$prefix = substr($methodName, 0, 3);
			if ($prefix != "get" && $prefix != "set")
				throw new \net\dryuf\core\RuntimeException("method $this->entityClass.$methodName does not start with get/set");
			$this->pkClass = \net\dryuf\core\Dryuf::getMethodReturnType($this->entityClass, $methodName);
			return lcfirst(substr($methodName, 3));
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
		return $this->entityManager->createQuery("SELECT ent FROM ".preg_replace('/.*\\\\/', '', $this->entityClass)." ent ORDER BY ".$this->pkName)->getResultList();
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
		return $this->entityManager->createQuery("DELETE FROM ".preg_replace('/.*\\\\/', '', $this->entityClass)." obj WHERE obj.".$this->pkName." = ?1")->setParameter(1, $pk)->executeUpdate() != 0;
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
