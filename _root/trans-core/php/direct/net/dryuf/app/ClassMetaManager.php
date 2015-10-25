<?php

namespace net\dryuf\app;


class ClassMetaManager extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	public static function		openCached($appContainer, $dataClass, $dataView)
	{
		return \net\dryuf\app\ClassMetaJava::openCached($appContainer, $dataClass, $dataView);
	}
};


?>
