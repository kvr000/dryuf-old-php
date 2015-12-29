<?php

namespace net\dryuf\dao\test\data;


/**
@\javax\persistence\Entity
@\javax\persistence\Table(name = "TestEnt")
*/
class TestEnt extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Id
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Column(name = "testId")
	*/
	public				$testId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getTestId()
	{
		return $this->testId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTestId($testId_)
	{
		$this->testId = $testId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "name")
	*/
	protected			$name = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "uniq")
	*/
	protected			$uniq = null;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "nonull")
	*/
	protected			$nonull = "";

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setName($name_)
	{
		$this->name = $name_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getName()
	{
		return $this->name;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUniq($uniq_)
	{
		$this->uniq = $uniq_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getUniq()
	{
		return $this->uniq;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setNonull($nonull_)
	{
		$this->nonull = $nonull_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getNonull()
	{
		return $this->nonull;
	}
};


?>
