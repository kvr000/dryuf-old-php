<?php

namespace net\dryuf\dao\test\data\dao\jpa;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class GenericDryufDaoJpa extends \net\dryuf\core\Object implements \net\dryuf\dao\test\data\dao\GenericDryufDao
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
	protected			$em;

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRES_NEW)
	*/
	public function			runNativeUpdate($sql)
	{
		$this->em->createNativeQuery($sql)->executeUpdate();
	}
};


?>
