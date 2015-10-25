<?php

namespace net\dryuf\comp\wedding\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class WeddingGiftsHeaderDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\wedding\dao\WeddingGiftsHeaderDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\wedding\WeddingGiftsHeader');
	}
};


?>
