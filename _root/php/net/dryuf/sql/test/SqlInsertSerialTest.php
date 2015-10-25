<?php

namespace net\dryuf\sql\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SqlInsertSerialTest extends \net\dryuf\tenv\AppTenvObject
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
	public function			testExecuteSerial()
	{
		$connection = $this->dataSource->getConnection();
		$connection->setAutoCommit(false);
		try {
			\net\dryuf\sql\SqlHelper::updateAny($connection, "DELETE FROM DryufStIncTable WHERE name LIKE ?", 
				array(
					'net\dryuf\sql\test\SqlInsertSerialTest'.".testExecuteSerial-%"
				));
			$st_insertIncTable = $connection->prepareStatement("INSERT INTO DryufStIncTable (name) VALUES (?)");
			$id0 = \net\dryuf\sql\SqlHelper::executeInsertSerial($st_insertIncTable, 
				array(
					'net\dryuf\sql\test\SqlInsertSerialTest'.".testExecuteSerial-name0"
				));
			$id1 = \net\dryuf\sql\SqlHelper::executeInsertSerial($st_insertIncTable, 
				array(
					'net\dryuf\sql\test\SqlInsertSerialTest'.".testExecuteSerial-name1"
				));
			\net\dryuf\tenv\DAssert::assertTrue($id1 != $id0, "id0 != id1");
			$connection->commit();
		}
		finally {
			$connection->close();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testRunSerial()
	{
		$connection = \net\dryuf\sql\SqlHelper::getDataSourceConnection($this->dataSource);
		\net\dryuf\sql\SqlHelper::setAutoCommit($connection, false);
		try {
			\net\dryuf\sql\SqlHelper::updateAny($connection, "DELETE FROM DryufStIncTable WHERE name LIKE ?", 
				array(
					'net\dryuf\sql\test\SqlInsertSerialTest'.".testRunSerial-%"
				));
			$id0 = \net\dryuf\sql\SqlHelper::runInsertSerial($connection, "DryufStIncTable", \net\dryuf\util\MapUtil::createStringNativeHashMap("name", 'net\dryuf\sql\test\SqlInsertSerialTest'.".testRunSerial-name0"));
			$id1 = \net\dryuf\sql\SqlHelper::runInsertSerial($connection, "DryufStIncTable", \net\dryuf\util\MapUtil::createStringNativeHashMap("name", 'net\dryuf\sql\test\SqlInsertSerialTest'.".testRunSerial-name1"));
			\net\dryuf\tenv\DAssert::assertTrue($id1 != $id0, "id0 != id1");
			\net\dryuf\sql\SqlHelper::commitConnection($connection);
		}
		finally {
			\net\dryuf\sql\SqlHelper::closeConnection($connection);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\sql\DataSource')
	@\javax\inject\Inject
	@\javax\inject\Named(value = "javax.sql.DataSource-dryuf")
	*/
	protected			$dataSource;
};


?>
