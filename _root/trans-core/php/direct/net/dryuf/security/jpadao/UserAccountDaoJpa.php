<?php

namespace net\dryuf\security\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class UserAccountDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\security\dao\UserAccountDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\security\UserAccount');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByUsername($username)
	{
		$result = $this->entityManager->createQuery("FROM UserAccount WHERE username = ?1")->setParameter(1, $username)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByOpenId($openId)
	{
		$result = $this->entityManager->createQuery("FROM UserAccount WHERE openId = ?1")->setParameter(1, $openId)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			setPassword($userId, $password, $activityStamp)
	{
		return $this->entityManager->createQuery("UPDATE UserAccount\nSET password = ?1, activityStamp = ?2\nWHERE userId = ?3")->setParameter(1, $password)->setParameter(2, $activityStamp)->setParameter(3, $userId)->executeUpdate() != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			updateActivity($userId, $activityStamp)
	{
		return $this->entityManager->createQuery("UPDATE UserAccount SET activityStamp = ?1 WHERE userId = ?2")->setParameter(1, $activityStamp)->setParameter(2, $userId)->executeUpdate() != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			activateUser($userId, $activityStamp)
	{
		return $this->entityManager->createQuery("UPDATE UserAccount\nSET activated = 1, activityStamp = ?1\nWHERE userId = ?2")->setParameter(1, $activityStamp)->setParameter(2, $userId)->executeUpdate() != 0;
	}
};


?>
