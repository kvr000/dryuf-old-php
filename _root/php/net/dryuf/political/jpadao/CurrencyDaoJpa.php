<?php

namespace net\dryuf\political\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class CurrencyDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\political\dao\CurrencyDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\political\Currency');
	}
};


?>
