<?php

namespace net\dryuf\political\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class CountryDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\political\dao\CountryDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\political\Country');
	}
};


?>
