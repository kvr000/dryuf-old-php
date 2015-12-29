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
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setName(\net\dryuf\core\Dryuf::dotClassname(get_class($this)).".testCorrect");
		$this->testEntDao->insert($te0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoPrimaryKeyConstraintException')
	*/
	public function			testDaoPrimaryKeyConstraint()
	{
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setName(\net\dryuf\core\Dryuf::dotClassname(get_class($this)).".testDaoPrimaryKeyConstraint.0");
		$this->testEntDao->insert($te0);
		$te1 = new \net\dryuf\dao\test\data\TestEnt();
		$this->genericDryufDao->runNativeUpdate("INSERT INTO TestEnt (testId, name, nonull) values (".$te0->getTestId().", '".\net\dryuf\core\Dryuf::dotClassname(get_class($this)).".testDaoPrimaryKeyConstraint.1"."', 'a')");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\dao\DaoBadNullConstraintException')
	*/
	public function			testDaoBadNullConstraintException()
	{
		$te0 = new \net\dryuf\dao\test\data\TestEnt();
		$te0->setName(\net\dryuf\core\Dryuf::dotClassname(get_class($this)).".testDaoBadNullConstraintException");
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
		$te0->setName(\net\dryuf\core\Dryuf::dotClassname(get_class($this)).".testDaoUniqueConstraintException.0");
		$te0->setUniq("four");
		$this->testEntDao->insert($te0);
		$te1 = new \net\dryuf\dao\test\data\TestEnt();
		$te1->setName(\net\dryuf\core\Dryuf::dotClassname(get_class($this)).".testDaoUniqueConstraintException.1");
		$te1->setUniq("four");
		$this->testEntDao->update($te1);
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
