<?php

namespace net\dryuf\sql\sqlite3\test;


class Sqlite3Test extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testLoad()
	{
		new \ReflectionClass('net\dryuf\sql\sqlite3\Sqlite3Connection');
		new \ReflectionClass('net\dryuf\sql\sqlite3\Sqlite3Statement');
		new \ReflectionClass('net\dryuf\sql\sqlite3\Sqlite3ResultSet');
		new \ReflectionClass('net\dryuf\sql\sqlite3\Sqlite3SqlDialect');
	}
};


?>
