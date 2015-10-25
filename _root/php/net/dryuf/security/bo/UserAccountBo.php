<?php

namespace net\dryuf\security\bo;


/**
 * Common error codes:
 * 
 * @return 0
 * 	if everything is successfull
 * @return 1
 * 	if the account does not exist
 * @return 2
 * 	if the password was wrong
 * @return 3
 * 	if the account is locked
 * @return 4
 * 	if the account expired
 * @return 5
 * 	if the account is not activated
 * @return 6
 * 	if the user already exists
 * @return 7
 * 	if the email already exists
 * @return 8
 * 	if the email already exists
 * @return 9
 * 	other unique constraint unsatisfied
 * 
 * @return 10
 * 	if the activation code is wrong
 */
interface UserAccountBo
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_Ok = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_UnknownAccount = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_WrongPassword = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_AccountLocked = 3;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_AccountExpired = 4;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_AccountUnactivated = 5;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_UserExists = 6;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_EmailExists = 7;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_OpenIdExists = 8;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_UniqueConstraint = 9;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ERR_BadActivationCode = 10;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			formatError($uiContext, $error);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			encodePassword($username, $salt, $plain);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainDef')
	*/
	function			getAppDomainDef();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getAppDomainId();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			genPassword();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			login($userAccount, $roles, $sid, $sourceIp);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			checkUserPassword($userId, $password);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			setUserPassword($userAccount, $newPassword);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			createUser($userInfo, $plainPassword);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getActivityCode($userId);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			digestString($input);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			updateActivity($userId);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			activateUser($username);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	*/
	function			load($userId);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			loadUsername($userId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	*/
	function			loadByUsername($username);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	function			listUserDomainRoles($userId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainDef')
	*/
	function			loadDomainByAlias($alias);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addUserDomainRoles($userInfo, $domainDef, $roles);

	/**
	 * Checks whether the caller is eligible for adding this domain role.
	 * 
	 * @param callerContext
	 * 	caller details
	 * 
	 * @return null
	 * 	if action is allowed
	 * @return required role name
	 * 	if the role is not allowed to be added by caller
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			checkRequiredRoleForRole($callerContext, $roleName);

	/**
	 * Checks whether the caller is eligible for adding this domain group.
	 * 
	 * @param callerContext
	 * 	caller details
	 * 
	 * @return null
	 * 	if action is allowed
	 * @return required role name
	 * 	if the group is not allowed to be added by caller
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			checkRequiredRoleForGroup($callerContext, $groupName);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	function			listAddableRoles($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	function			listAddableGroups($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	function			getAddableRolesDependencies();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	function			getAddableGroupsDependencies();
};


?>
