<?php

namespace net\dryuf\dao\test\data\dao\jpa;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class TestEntDaoJpa extends \net\dryuf\core\Object implements \net\dryuf\dao\test\data\dao\TestEntDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\persistence\EntityManager')
	@\javax\persistence\PersistenceContext(unitName = "dryuf")
	*/
	protected			$entityManager;

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRES_NEW)
	*/
	public function			insert($obj)
	{
		$this->entityManager->persist($obj);
		$this->entityManager->flush();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRES_NEW)
	*/
	public function			update($obj)
	{
		$this->entityManager->merge($obj);
		$this->entityManager->flush();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRES_NEW)
	*/
	public function			remove($obj)
	{
		$this->entityManager->remove($obj);
		$this->entityManager->flush();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<net\dryuf\dao\test\data\TestEnt>')
	*/
	public function			listAll()
	{
		$result = $this->entityManager->createQuery("FROM TestEnt ORDER BY testId")->getResultList();
		return $result;
	}
};


?>
