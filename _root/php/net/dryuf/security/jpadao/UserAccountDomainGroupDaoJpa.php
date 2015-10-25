<?php

namespace net\dryuf\security\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class UserAccountDomainGroupDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\security\dao\UserAccountDomainGroupDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\security\UserAccountDomainGroup');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\security\UserAccountDomainGroup>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM UserAccountDomainGroup WHERE pk.domain = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM UserAccountDomainGroup obj WHERE obj.pk.domain = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			initUserWithDefaultGroups($userId, $domain)
	{
		return $this->entityManager->createNativeQuery("INSERT INTO UserAccountDomainGroup (userId, domain, groupName) SELECT ?, adr.domain, adr.groupName FROM AppDomainGroup adr WHERE adr.domain = ? AND adr.defaultDependencyRole = ''")->setParameter(1, $userId)->setParameter(2, $domain)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			listGroupRolesForUserDomain($userId, $domain)
	{
		return $this->entityManager->createQuery("SELECT adgr.pk.roleName\n\tFROM AppDomainGroupRole adgr\n\tWHERE ( adgr.pk.domainGroup.domain, adgr.pk.domainGroup.groupName ) IN (SELECT udg.pk.domain.domain, udg.pk.groupName FROM UserAccountDomainGroup udg WHERE udg.pk.domain.userId = ?1 AND udg.pk.domain.domain = ?2)", 'string')->setParameter(1, $userId)->setParameter(2, $domain)->getResultList();
	}
};


?>
