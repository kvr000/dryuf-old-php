<?php

namespace net\dryuf\sql\pgsql\test;


class PgsqlTest extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testLoad()
	{
		new \ReflectionClass('net\dryuf\sql\pgsql\PgsqlConnection');
		new \ReflectionClass('net\dryuf\sql\pgsql\PgsqlStatement');
		new \ReflectionClass('net\dryuf\sql\pgsql\PgsqlResultSet');
		new \ReflectionClass('net\dryuf\sql\pgsql\PgsqlSqlDialect');
	}
};


?>
