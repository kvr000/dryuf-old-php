<?php

namespace net\dryuf\menu\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class WebLanguageDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\menu\dao\WebLanguageDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\menu\WebLanguage');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebLanguage>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM WebLanguage WHERE pk.providerName = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM WebLanguage obj WHERE obj.pk.providerName = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
