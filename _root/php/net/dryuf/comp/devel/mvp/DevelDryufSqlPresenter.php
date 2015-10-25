<?php

namespace net\dryuf\comp\devel\mvp;


class DevelDryufSqlPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'org\springframework\transaction\PlatformTransactionManager')
	*/
	protected			$transactionManagerDr;

	/**
	@\net\dryuf\core\Type(type = 'javax\persistence\EntityManager')
	@\javax\persistence\PersistenceContext(unitName = "dryuf")
	*/
	protected			$em;

	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->transactionManagerDr = $this->getCallerContext()->getBeanTyped("transactionManager-dryuf", 'org\springframework\transaction\PlatformTransactionManager');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\devel\form\DevelDryufSqlForm')
	*/
	public function			createBackingObject()
	{
		return new \net\dryuf\comp\devel\form\DevelDryufSqlForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performRunSql($action)
	{
		$develDryufSqlForm = $this->getBackingObject();
		$txStatus = $this->transactionManagerDr->getTransaction(new \org\springframework\transaction\support\DefaultTransactionDefinition());
		$ran = 0;
		$statement = null;
		try {
			if (!is_null($develDryufSqlForm->getSqlFile())) {
				$sqlFile = $this->getRequest()->getFile($this->getFormFieldName("sqlFile"));
				foreach (\net\dryuf\core\StringUtil::splitRegExp(stream_get_contents($sqlFile->getInputStream(), "UTF-8"), ";\\s*\n") as $statement_) {
					$statement = $statement_;
					$this->em->createNativeQuery($statement)->executeUpdate();
					$ran++;
				}
			}
			if (!is_null($develDryufSqlForm->getSql())) {
				foreach (\net\dryuf\core\StringUtil::splitRegExp($develDryufSqlForm->getSql(), ";\\s*\n") as $statement_) {
					$statement = $statement_;
					$this->em->createNativeQuery($statement)->executeUpdate();
					$ran++;
				}
			}
		}
		catch (\net\dryuf\core\Exception $ex) {
			$this->transactionManagerDr->rollback($txStatus);
			throw new \net\dryuf\core\RuntimeException(strval($ex).", when running ".$statement, $ex);
		}
		$this->transactionManagerDr->commit($txStatus);
		$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Info, "successfully ran ".$ran." statements");
		return true;
	}
};


?>
