<?php

namespace net\dryuf\menu\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class WebAccessiblePageDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\menu\dao\WebAccessiblePageDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\menu\WebAccessiblePage');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebAccessiblePage>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM WebAccessiblePage WHERE pk.providerName = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM WebAccessiblePage obj WHERE obj.pk.providerName = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebAccessiblePage')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByPageCode($providerName, $pageCode)
	{
		$result = $this->entityManager->createQuery("FROM WebAccessiblePage WHERE providerName = ?1 AND pageCode = ?2")->setParameter(1, $providerName)->setParameter(2, $pageCode)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}
};


?>
