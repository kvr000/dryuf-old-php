<?php

namespace net\dryuf\comp\devel\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class DevelFileDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\devel\dao\DevelFileDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\devel\DevelFile');
	}
};


?>
