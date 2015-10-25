<?php

namespace net\dryuf\dao;


interface JpaExceptionTranslator
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			translateJpaException($ex);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DaoAccessException')
	*/
	function			translateDaoExceptionIfPossible($ex);
};


?>
