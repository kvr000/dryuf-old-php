<?php

namespace net\dryuf\security\UserAccount;


class UserRole extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Guest = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Free = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_User = 4;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Admin = 8;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Sysmeta = 16;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Sysconf = 32;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Swapuser = 64;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Dataop = 128;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Devel = 256;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Extreme = 512;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Translation = 1024;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				UR_Timing = 2048;
};


?>
