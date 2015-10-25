<?php

namespace net\dryuf\security\textual;


class UserAccountRoleTextual extends \net\dryuf\textual\GenericIntegerSetTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\security\textual\UserAccountRoleTextual'), self::$roleMapping);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\String, java\lang\Integer>')
	*/
	static				$roleMapping;

	public static function		_initManualStatic()
	{
		self::$roleMapping = \net\dryuf\util\MapUtil::createStringNativeHashMap("guest", \net\dryuf\security\UserAccount\UserRole::UR_Guest, "free", \net\dryuf\security\UserAccount\UserRole::UR_Free, "user", \net\dryuf\security\UserAccount\UserRole::UR_User, "admin", \net\dryuf\security\UserAccount\UserRole::UR_Admin, "sysmeta", \net\dryuf\security\UserAccount\UserRole::UR_Sysmeta, "sysconf", \net\dryuf\security\UserAccount\UserRole::UR_Sysconf, "swapuser", \net\dryuf\security\UserAccount\UserRole::UR_Swapuser, "dataop", \net\dryuf\security\UserAccount\UserRole::UR_Dataop, "devel", \net\dryuf\security\UserAccount\UserRole::UR_Devel, "extreme", \net\dryuf\security\UserAccount\UserRole::UR_Extreme, "translation", \net\dryuf\security\UserAccount\UserRole::UR_Translation, "timing", \net\dryuf\security\UserAccount\UserRole::UR_Timing);
	}

};

\net\dryuf\security\textual\UserAccountRoleTextual::_initManualStatic();


?>
