<?php

namespace net\dryuf\core;


/**
 * {@code AppContainer} manages the beans and set up of the application.
 */
interface AppContainer
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getWorkRoot();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getAppRoot();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getConfigValue($name, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	function			getCpResource($file);

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			getCpResourceContent($file);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			postProcessBean($bean, $name, $params);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			createCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getBean($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getBeanTyped($name, $clazz);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			createBeaned($clazz, $injects);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			createBeanedArgs($constructor, $args, $injects);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getGlobalRoles();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			checkRoleDependency($roleName);
};


?>
