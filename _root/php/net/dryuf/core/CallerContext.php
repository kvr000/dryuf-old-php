<?php

namespace net\dryuf\core;


/**
 * {@code CallerContext} represents context of the calling party.
 * 
 * It provides reference to application container and also information about the user.
 */
interface CallerContext extends \java\lang\AutoCloseable
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	function			getAppContainer();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getWorkRoot();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getAppRoot();

	/**
	 * Gets root context from this caller context.
	 * 
	 * @return
	 * 	root context
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			getRootContext();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getUserId();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getRealUserId();

	/**
	 * Checks whether the user is logged in.
	 * 
	 * @return
	 * 	the indicator whether the user is logged in
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			isLoggedIn();

	/**
	 * checks if the context has appropriate role (specified as comma separated list of roles)
	 * 
	 * @return false
	 * 	if the role is not available
	 * @return true
	 * 	if the role is available
	 */
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			checkRole($role);

	/**
	 * gets the list of roles
	 * 
	 * @return array of available roles
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	function			getRoles();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getConfigValue($name, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getContextVar($name);

	/**
	 * Closes all associated resources.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			close();

	/**
	 * Checks whether handler of specified identifier is opened within this context.
	 * 
	 * @return null
	 * 	if no handler is found
	 * @return handler
	 * 	handler associated with the identifier
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\AutoCloseable')
	*/
	function			checkResource($identifier);

	/**
	 * Saves handler of specified name in this context.
	 * 
	 * @param identifier
	 * 	handler identifier
	 * @param handler
	 * 	handler to be associated with identifier
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			saveResource($identifier, $handler);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			createFullContext();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			createBeaned($clazz, $injects);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			createBeanedArgs($constructor, $args, $injects);

	/**
	 * Gets bean of the specified name.
	 * 
	 * @param name
	 * 	name of the bean
	 * 
	 * @return bean
	 * 	in case of success
	 * 
	 * @throw RuntimeException
	 * 	in case the bean was not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getBean($name);

	/**
	 * Gets bean of the specified name and type.
	 * 
	 * @param name
	 * 	name of the bean
	 * @param clazz
	 * 	type of the bean
	 * 
	 * @return bean
	 * 	in case of success
	 * 
	 * @throw RuntimeException
	 * 	in case the bean was not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getBeanTyped($name, $clazz);

	/**
	 * Notifies context about being logged off.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			loggedOut();

	/**
	 * Gets UI Context for this context.
	 * 
	 * @return ui context
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	function			getUiContext();
};


?>
