<?php

namespace net\dryuf\tenv\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class TestMainDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\tenv\dao\TestMainDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\tenv\TestMain');
	}
};


?>
