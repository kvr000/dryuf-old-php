<?php

namespace net\dryuf\core;


/**
 * {@link CallerContext} forwarding all its methods to its parent.
 */
class SubCallerContext extends \net\dryuf\core\Object implements \net\dryuf\core\CallerContext
{
	/**
	*/
	function			__construct($parentContext)
	{
		parent::__construct();
		$this->parentContext = $parentContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	public function			getAppContainer()
	{
		return $this->parentContext->getAppContainer();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getUserId()
	{
		return $this->parentContext->getUserId();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getRealUserId()
	{
		return $this->parentContext->getRealUserId();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getWorkRoot()
	{
		return $this->parentContext->getWorkRoot();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getAppRoot()
	{
		return $this->parentContext->getAppRoot();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getRootContext()
	{
		return $this->parentContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isLoggedIn()
	{
		return $this->parentContext->isLoggedIn();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkRole($role)
	{
		return $this->parentContext->checkRole($role);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getRoles()
	{
		return $this->parentContext->getRoles();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getConfigValue($name, $defaultValue)
	{
		return $this->parentContext->getConfigValue($name, $defaultValue);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getContextVar($name)
	{
		return $this->parentContext->getContextVar($name);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			createFullContext()
	{
		return $this->parentContext->createFullContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			close()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\AutoCloseable')
	*/
	public function			checkResource($identifier)
	{
		return $this->parentContext->checkResource($identifier);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			saveResource($identifier, $handler)
	{
		$this->parentContext->saveResource($identifier, $handler);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			createBeaned($clazz, $injects)
	{
		return $this->parentContext->createBeaned($clazz, $injects);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			createBeanedArgs($constructor, $args, $injects)
	{
		return $this->parentContext->createBeanedArgs($constructor, $args, $injects);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getBean($name)
	{
		return $this->parentContext->getBean($name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getBeanTyped($name, $clazz)
	{
		return $this->parentContext->getBeanTyped($name, $clazz);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			loggedOut()
	{
		$this->parentContext->loggedOut();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	public function			getUiContext()
	{
		if (is_null($this->uiContext))
			$this->uiContext = $this->parentContext->getUiContext();
		return $this->uiContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$parentContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	protected			$uiContext;
};


?>
