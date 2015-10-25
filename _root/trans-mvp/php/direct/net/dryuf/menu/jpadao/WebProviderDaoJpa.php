<?php

namespace net\dryuf\menu\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class WebProviderDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\menu\dao\WebProviderDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\menu\WebProvider');
	}
};


?>
