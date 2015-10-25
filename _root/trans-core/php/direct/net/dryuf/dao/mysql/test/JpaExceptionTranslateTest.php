<?php

namespace net\dryuf\dao\mysql\test;


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
	*/
	function			__construct()
	{
		parent::__construct();
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
	@\org\junit\Before
	*/
	public function			createStructure()
	{
		$this->runSql("DELETE FROM TestEnt");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		$this->runSql("INSERT INTO TestEnt (testId) VALUES (1)");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoPrimaryKeyConstraintException')
	*/
	public function			testDaoPrimaryKeyConstraint()
	{
		$this->runSql("INSERT INTO TestEnt (testId) VALUES (2)");
		$this->runSql("INSERT INTO TestEnt (testId) VALUES (2)");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoBadNullConstraintException')
	*/
	public function			testDaoBadNullConstraintException()
	{
		$this->runSql("INSERT INTO TestEnt (testId, nonull) VALUES (3, null)");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoUniqueConstraintException')
	*/
	public function			testDaoUniqueConstraintException()
	{
		$this->runSql("INSERT INTO TestEnt (testId, uniq) VALUES (4, 1)");
		$this->runSql("INSERT INTO TestEnt (testId, uniq) VALUES (5, 1)");
	}
};


?>
