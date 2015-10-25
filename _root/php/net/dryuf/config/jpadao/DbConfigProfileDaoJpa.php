<?php

namespace net\dryuf\config\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class DbConfigProfileDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\config\dao\DbConfigProfileDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\config\DbConfigProfile');
	}
};


?>
