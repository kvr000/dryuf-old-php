<?php

namespace net\dryuf\dao\mysql;


class JpaExceptionTranslatorMysql extends \net\dryuf\core\Object implements \net\dryuf\dao\JpaExceptionTranslator
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			translateJpaException($ex)
	{
		$newex = $this->translateDaoExceptionIfPossible($ex);
		throw is_null($newex) ? $ex : $newex;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DaoAccessException')
	*/
	public function			translateDaoExceptionIfPossible($ex)
	{
		for ($cause = $ex; !is_null($cause); $cause = $cause->getCause()) {
			if ($cause instanceof \net\dryuf\sql\SqlException) {
				return $this->getSqlException($ex, $cause);
			}
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DaoAccessException')
	*/
	public function			getSqlException($ex, $sqlex)
	{
		switch ($sqlex->getErrorCode()) {
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_DUP_KEY:
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_DUP_ENTRY:
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_DUP_ENTRY_WITH_KEY_NAME:
			return new \net\dryuf\dao\DaoPrimaryKeyConstraintException($ex);

		case \net\dryuf\sql\mysqli\MysqliConnection::ER_DUP_ENTRY_AUTOINCREMENT_CASE:
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_DUP_UNIQUE:
			return new \net\dryuf\dao\DaoUniqueConstraintException($ex);

		case \net\dryuf\sql\mysqli\MysqliConnection::ER_BAD_NULL_ERROR:
			return new \net\dryuf\dao\DaoBadNullConstraintException($ex);

		case \net\dryuf\sql\mysqli\MysqliConnection::ER_NO_REFERENCED_ROW:
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_NO_REFERENCED_ROW_2:
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_ROW_IS_REFERENCED:
		case \net\dryuf\sql\mysqli\MysqliConnection::ER_ROW_IS_REFERENCED_2:
			return new \net\dryuf\dao\DaoForeignKeyConstraintException($ex);
		}
		return null;
	}
};


?>
