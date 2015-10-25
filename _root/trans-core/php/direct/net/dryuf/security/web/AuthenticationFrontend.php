<?php

namespace net\dryuf\security\web;


interface AuthenticationFrontend
{
	/**
	 * Authenticates user and password pair and sets up user session context.
	 * 
	 * @param pageContext
	 * 	frontend presenter
	 * @param username
	 * 	username provided by user
	 * @param password
	 * 	password provided by user
	 * 
	 * @return net.dryuf.security.bo.UserAccountBo.ERR_Ok
	 * 	if authentication was successful
	 * @return error code from net.dryuf.security.bo.UserAccountBo
	 * 	if authentication failed
	 */
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			authenticateUserPassword(\net\dryuf\srvui\PageContext $pageContext, $username, $password);

	/**
	 * Creates caller context from the request.
	 * 
	 * @param request
	 * 	Incoming request
	 * 
	 * @return caller context
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			initCallerContext(\net\dryuf\srvui\Request $request);

	/**
	 * Logs out user.
	 * 
	 * @param pageContext
	 * 	frontend pageContext
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			logout(\net\dryuf\srvui\PageContext $pageContext);

	/**
	 * Sets effective user id.
	 * 
	 * @param pageContext
	 * 	frontend presenter
	 * @param userId
	 * 	the user id of effective user
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setEffectiveUserId(\net\dryuf\srvui\PageContext $pageContext, $userId);

	/**
	 * Resets the roles currently assigned to user.
	 * 
	 * @param pageContext
	 * 	frontend presenter
	 * @param newRoles
	 * 	new roles for the current session
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			resetRoles(\net\dryuf\srvui\PageContext $pageContext, $newRoles);

	/**
	 * Sets translation level for current session.
	 * 
	 * @param pageContext
	 * 	frontend presenter
	 * @param translationLevel
	 * 	new translation level
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setTranslationLevel(\net\dryuf\srvui\PageContext $pageContext, $translationLevel);

	/**
	 * Sets translation level for current session.
	 * 
	 * @param pageContext
	 * 	frontend presenter
	 * @param timing
	 * 	timing indicator
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setTiming(\net\dryuf\srvui\PageContext $pageContext, $timing);
};


?>
