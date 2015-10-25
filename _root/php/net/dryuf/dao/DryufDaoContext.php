<?php

namespace net\dryuf\dao;


/**
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
*/
class DryufDaoContext extends \net\dryuf\dao\DaoContextBase
{
	/**
	*/
	function			__construct($entityClass)
	{
		parent::__construct($entityClass);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\persistence\PersistenceContext(unitName = "dryuf")
	*/
	public function			setEntityManager($em)
	{
		parent::setEntityManagerInternal($em);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\inject\Inject
	@\javax\inject\Named(value = "net.dryuf.transaction.TransactionManager-dryuf")
	*/
	public function			setTransactionManager($transactionManager)
	{
		parent::setTransactionManagerInternal($transactionManager);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByPk($pk)
	{
		return parent::loadByPk($pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Object>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			listAll()
	{
		return parent::listAll();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			insert($obj)
	{
		parent::insert($obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRES_NEW)
	*/
	public function			insertTxNew($obj)
	{
		parent::insertTxNew($obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			update($obj)
	{
		return parent::update($obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			remove($obj)
	{
		parent::remove($obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByPk($pk)
	{
		return parent::removeByPk($pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			openRelation($holder, $relation)
	{
		return parent::openRelation($holder, $relation);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			importDynamicKey($data)
	{
		return parent::importDynamicKey($data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			exportDynamicData($holder)
	{
		return parent::exportDynamicData($holder);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			exportEntityData($holder)
	{
		return parent::exportEntityData($holder);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			createDynamic($composition, $data)
	{
		return parent::createDynamic($composition, $data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			retrieveDynamic($composition, $pk)
	{
		return parent::retrieveDynamic($composition, $pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			updateDynamic($roleObject, $pk, $updates)
	{
		return parent::updateDynamic($roleObject, $pk, $updates);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			deleteDynamic($composition, $pk)
	{
		return parent::deleteDynamic($composition, $pk);
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			listDynamic($results, $composition, $filter, $sorts, $start, $limit)
	{
		return parent::listDynamic($results, $composition, $filter, $sorts, $start, $limit);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			runTransactioned($code)
	{
		return call_user_func($code);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			runTransactionedSafe($code)
	{
		try {
			return call_user_func($code);
		}
		catch (\net\dryuf\core\RuntimeException $ex) {
			throw $ex;
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}
};


?>
