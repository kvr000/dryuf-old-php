<?php

namespace net\dryuf\dao\test\common;


/**
@\org\junit\Ignore(value = "base class only")
*/
class AbstractTestEntOperBase extends \net\dryuf\core\Object
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
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setTestId(1);
		$this->testEntDao->insert($te0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoPrimaryKeyConstraintException')
	*/
	public function			testDaoPrimaryKeyConstraint()
	{
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setTestId(2);
		$this->testEntDao->insert($te0);
		$te1 = new \net\dryuf\dao\test\data\TestEnt();
		$te1->setTestId(2);
		$this->testEntDao->insert($te1);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoBadNullConstraintException')
	*/
	public function			testDaoBadNullConstraintException()
	{
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setTestId(3);
		$te0->setNonull(null);
		$this->testEntDao->insert($te0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoUniqueConstraintException')
	*/
	public function			testDaoUniqueConstraintException()
	{
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setTestId(4);
		$te0->setUniq("four");
		$this->testEntDao->insert($te0);
		$te1 = new \net\dryuf\dao\test\data\TestEnt();
		$te1->setTestId(5);
		$te1->setUniq("four");
		$this->testEntDao->insert($te1);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\test\data\dao\GenericDryufDao')
	@\javax\inject\Inject
	*/
	protected			$genericDryufDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\test\data\dao\TestEntDao')
	@\javax\inject\Inject
	*/
	protected			$testEntDao;
};


?>
