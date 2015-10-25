<?php

namespace net\dryuf\sql\mysqli\test;


class MysqliTest extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testLoad()
	{
		new \ReflectionClass('net\dryuf\sql\mysqli\MysqliConnection');
		new \ReflectionClass('net\dryuf\sql\mysqli\MysqliStatement');
		new \ReflectionClass('net\dryuf\sql\mysqli\MysqliResultSet');
		new \ReflectionClass('net\dryuf\sql\mysqli\MysqliSqlDialect');
	}
};


?>
