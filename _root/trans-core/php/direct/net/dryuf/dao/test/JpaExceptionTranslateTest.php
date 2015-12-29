<?php

namespace net\dryuf\dao\test;


/**
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
*/
class JpaExceptionTranslateTest extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\test\data\dao\GenericDryufDao')
	@\javax\inject\Inject
	*/
	protected			$genericDryufDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\tenv\dao\TestMainDao')
	@\javax\inject\Inject
	*/
	protected			$testMainDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\tenv\dao\TestChildDao')
	@\javax\inject\Inject
	*/
	protected			$testChildDao;

	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			allocateTestMain($name)
	{
		$testMain = new \net\dryuf\tenv\TestMain();
		$testMain->setName(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\dao\test\JpaExceptionTranslateTest')."-".$name);
		$testMain->setSvalue($testMain->getName());
		if (\net\dryuf\core\StringUtil::indexOf($name, "'") >= 0 || \net\dryuf\core\StringUtil::indexOf($name, "\\") >= 0)
			throw new \net\dryuf\core\IllegalArgumentException("unexpected value from test, identifier cannot contain ' or \\");
		$this->runSql("DELETE FROM TestMain WHERE name = '".$name."'");
		$this->testMainDao->insert($testMain);
		$this->testChildDao->removeByCompos($testMain->getTestId());
		return $testMain->getTestId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			runSqlSafe($sql)
	{
		try {
			$this->genericDryufDao->runNativeUpdate($sql);
		}
		catch (\net\dryuf\core\Exception $ex) {
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			runSql($sql)
	{
		$this->genericDryufDao->runNativeUpdate($sql);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		$id = $this->allocateTestMain("testCorrect");
		$this->runSql("INSERT INTO TestChild (testId, childId, svalue) VALUES (".$id.", 1, '1')");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoPrimaryKeyConstraintException')
	*/
	public function			testDaoPrimaryKeyConstraint()
	{
		$id = $this->allocateTestMain("testDaoPrimaryKeyConstraint");
		$this->runSql("INSERT INTO TestChild (testId, childId, svalue) VALUES (".$id.", 2, '1')");
		$this->runSql("INSERT INTO TestChild (testId, childId, svalue) VALUES (".$id.", 2, '2')");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoBadNullConstraintException')
	*/
	public function			testDaoBadNullConstraintException()
	{
		$id = $this->allocateTestMain("testDaoBadNullConstraintException");
		$this->runSql("INSERT INTO TestChild (testId, childId) VALUES (".$id.", null)");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoUniqueConstraintException')
	*/
	public function			testDaoUniqueConstraintException()
	{
		$id = $this->allocateTestMain("testDaoUniqueConstraintException");
		$this->runSql("INSERT INTO TestChild (testId, childId, svalue) VALUES (".$id.", 4, '1')");
		$this->runSql("INSERT INTO TestChild (testId, childId, svalue) VALUES (".$id.", 5, '1')");
	}
};


?>
