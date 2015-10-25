<?php

namespace net\dryuf\security\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class UserAccountDomainRoleDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\security\dao\UserAccountDomainRoleDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\security\UserAccountDomainRole');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\security\UserAccountDomainRole>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM UserAccountDomainRole WHERE pk.domain = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM UserAccountDomainRole obj WHERE obj.pk.domain = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			initUserWithDefaultRoles($userId, $domain)
	{
		return $this->entityManager->createNativeQuery("INSERT INTO UserAccountDomainRole (userId, domain, roleName) SELECT ?, adr.domain, adr.roleName FROM AppDomainRole adr WHERE adr.domain = ? AND adr.defaultDependencyRole = ''")->setParameter(1, $userId)->setParameter(2, $domain)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			listRolesForUserDomain($userId, $domain)
	{
		return $this->entityManager->createQuery("SELECT udr.pk.roleName FROM UserAccountDomainRole udr WHERE udr.pk.domain.userId = ?1 AND udr.pk.domain.domain = ?2")->setParameter(1, $userId)->setParameter(2, $domain)->getResultList();
	}
};


?>
