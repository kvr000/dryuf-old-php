<?php

namespace net\dryuf\menu\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class WebMenuItemDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\menu\dao\WebMenuItemDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\menu\WebMenuItem');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM WebMenuItem WHERE pageCode = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM WebMenuItem obj WHERE obj.pk.pageCode = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			listRooted($providerName)
	{
		$result = $this->entityManager->createQuery("SELECT mi FROM WebMenuItem mi WHERE providerName = ?1 parentItem IS NULL ORDER BY subOrder")->setParameter(1, $providerName)->getResultList();
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			listByParent($providerName, $parentItem)
	{
		$result = $this->entityManager->createQuery("SELECT mi FROM WebMenuItem mi WHERE providerName = ?1 AND parentItem = ?2 ORDER BY subOrder")->setParameter(1, $providerName)->setParameter(2, $parentItem)->getResultList();
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebAccessiblePage>')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			listPagesRooted($providerName)
	{
		$result = $this->entityManager->createQuery("SELECT page FROM WebMenuItem mi, WebAccessiblePage page WHERE page.pk = mi.pageCode AND mi.pageCode.providerName = ?1 AND mi.parentItem IS NULL ORDER BY mi.subOrder")->setParameter(1, $providerName)->getResultList();
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebAccessiblePage>')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			listPagesByParent($providerName, $parentItem)
	{
		$result = $this->entityManager->createQuery("SELECT page FROM WebMenuItem mi, WebAccessiblePage page WHERE page.pk = mi.pageCode AND mi.pageCode.providerName = ?1 AND mi.parentItem = ?2 ORDER by mi.subOrder")->setParameter(1, $providerName)->setParameter(2, $parentItem)->getResultList();
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByPageCode($providerName, $pageCode)
	{
		$result = $this->entityManager->createQuery("FROM WebMenuItem WHERE providerName = ?1 AND pageCode = ?2")->setParameter(1, $providerName)->setParameter(2, $pageCode)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}
};


?>
