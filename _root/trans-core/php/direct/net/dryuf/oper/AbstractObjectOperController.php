<?php

namespace net\dryuf\oper;


abstract class AbstractObjectOperController extends \net\dryuf\core\Object implements \net\dryuf\oper\ObjectOperController, \net\dryuf\core\AppContainerAware
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public abstract function	getDataClass();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operate($operContext, $ownerHolder)
	{
		$objectId = $this->getObjectId($operContext);
		if (is_null(($actionName = $operContext->getPathElement()))) {
			return is_null($objectId) ? $this->operateStaticCommon($operContext, $ownerHolder) : $this->operateObjectCommon($operContext, $ownerHolder, $objectId);
		}
		if ($operContext->hasError())
			return null;
		$actioner = $this->findActioner($actionName);
		if (is_null($actioner)) {
			$operContext->markNotFound();
			return null;
		}
		$rules = $actioner->getOperRules();
		if ($rules->isFinal()) {
			if (false && !$operContext->needPathSlash(false)) {
				return null;
			}
		}
		else {
			if (!$operContext->needPathSlash(true)) {
				return null;
			}
		}
		if ($rules->isStatic()) {
			return $this->operateStaticAction($actioner, $rules, $operContext, $ownerHolder);
		}
		else {
			return $this->operateObjectAction($actioner, $rules, $operContext, $ownerHolder, $objectId);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getObjectId($operContext)
	{
		return $this->getObjectIdList($operContext, 1);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getObjectIdList($operContext, $count)
	{
		$ids = \net\dryuf\core\Dryuf::allocArray(null, $count);
		for ($i = 0; $i < $count; $i++) {
			if (is_null(($ids[$i] = $operContext->getPathElement()))) {
				return null;
			}
			if (!$operContext->needPathSlash(true)) {
				return null;
			}
		}
		return $ids;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\AbstractObjectOperController\Actioner')
	*/
	public function			findActioner($actionName)
	{
		$found = \org\reflections\ReflectionUtils::getAllMethods(get_class($this), 
			function ($pmethod) use ($actionName) {
				$prules = (=f_I_x=)pmethod.getAnnotation(ObjectOperRules.class)(=x_I_f=);
				if (is_null($prules))
					return false;
				if (!($prules->value() === $actionName))
					return false;
				return true;
			}
		);
		if ($found->isEmpty()) {
			return null;
		}
		if ($found->size() > 1)
			throw new \net\dryuf\core\InvalidValueException($found, "more than one method found handling the action: ".$actionName);
		$method = $found->iterator()->next();
		$rules = (=f_I_x=)method.getAnnotation(ObjectOperRules.class)(=x_I_f=);
		return new \net\dryuf\oper\AbstractObjectOperController\Actioner()(=f_I_x=)
		class  {
		    
		    @Override()
		    public String getActionName() {
		        return actionName;
		    }
		    
		    @Override()
		    public ObjectOperRules getOperRules() {
		        return rules;
		    }
		    
		    @Override()
		    public Object runAction(AbstractObjectOperController<?> controller, ObjectOperContext operContext, EntityHolder<?> ownerHolder) {
		        if (rules.actionClass() != void.class) {
		            return Dryuf.invokeMethod(AbstractObjectOperController.this, method, operContext, ownerHolder, operContext.getActionData(rules.actionClass()));
		        } else {
		            return Dryuf.invokeMethod(AbstractObjectOperController.this, method, operContext, ownerHolder);
		        }
		    }
		}(=x_I_f=);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		keepContextTransaction($callerContext)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected function		loadObject($ownerHolder, $objectId)
	{
		throw new \net\dryuf\core\UnsupportedOperationException(get_class($this).".loadObject");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getInputData($operContext)
	{
		return $operContext->getInputData();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticCommon($operContext, $ownerHolder)
	{
		switch ($operContext->getStaticOperMethod()) {
		case \net\dryuf\oper\ObjectOperMethod::META:
			$response = $operContext->getResponse();
			$response->setContentType("text/xml; charset=UTF-8");
			try {
				stream_put_contents($response->getOutputStream(), $this->operateStaticMeta($operContext, $ownerHolder));
			}
			catch (\net\dryuf\io\IoException $e) {
				throw new \net\dryuf\core\RuntimeException($e);
			}
			return new \net\dryuf\oper\ObjectOperController\SkipContainer();

		case \net\dryuf\oper\ObjectOperMethod::ROLE:
			return $ownerHolder->getRole();

		case \net\dryuf\oper\ObjectOperMethod::CREATE:
			return $this->operateStaticCreate($operContext, $ownerHolder, $this->getInputData($operContext));

		case \net\dryuf\oper\ObjectOperMethod::LIST:
			return $this->operateStaticList($operContext, $ownerHolder);

		case \net\dryuf\oper\ObjectOperMethod::SUGGEST:
			return $this->operateStaticSuggest($operContext, $ownerHolder);

		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unknown method used on object tree root: ".$operContext->getStaticOperMethod());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController\RoleContainer')
	*/
	public function			operateStaticRole($operContext, $ownerHolder)
	{
		return new \net\dryuf\oper\ObjectOperController\RoleContainer($ownerHolder->getRole());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			operateStaticMeta($operContext, $ownerHolder)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unknown method used on object tree root: meta");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticList($operContext, $ownerHolder)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unknown method used on object tree root: list");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticSuggest($operContext, $ownerHolder)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unknown method used on object tree root: suggest");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticCreate($operContext, $ownerHolder, $readValue)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unknown method used on object tree root: create");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectCommon($operContext, $ownerHolder, $objectId)
	{
		if (is_null($ownerHolder))
			return null;
		switch ($operContext->getObjectOperMethod()) {
		case \net\dryuf\oper\ObjectOperMethod::CREATE:
		case \net\dryuf\oper\ObjectOperMethod::UPDATE:
			$objectHolder = $this->loadObject($ownerHolder, $objectId);
			if (is_null($objectHolder))
				return null;
			return $this->operateObjectUpdate($operContext, $objectHolder, $this->getInputData($operContext));

		case \net\dryuf\oper\ObjectOperMethod::RETRIEVE:
			$this->keepContextTransaction($ownerHolder->getRole());
			$retrievedHolder = $this->loadObject($ownerHolder, $objectId);
			if (is_null($retrievedHolder))
				return null;
			return $this->operateObjectRetrieve($operContext, $retrievedHolder);

		case \net\dryuf\oper\ObjectOperMethod::DELETE:
			$deletingHolder = $this->loadObject($ownerHolder, $objectId);
			return $this->operateObjectDelete($operContext, $deletingHolder);

		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unknown method used on object tree root: ".$operContext->getObjectOperMethod());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectRetrieve($operContext, $objectHolder)
	{
		throw new \net\dryuf\core\UnsupportedOperationException(get_class($this).".operateObjectRetrieve");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectUpdate($operContext, $objectHolder, $data)
	{
		throw new \net\dryuf\core\UnsupportedOperationException(get_class($this).".operateObjectUpdate");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectDelete($operContext, $objectHolder)
	{
		throw new \net\dryuf\core\UnsupportedOperationException(get_class($this).".operateObjectDelete");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticAction($actioner, $rules, $operContext, $ownerHolder)
	{
		if (!$ownerHolder->getRole()->checkRole($rules->reqRole())) {
			$operContext->markDenied();
			return null;
		}
		return $actioner->runAction($this, $operContext, $ownerHolder);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectAction($actioner, $rules, $operContext, $ownerHolder, $objectId)
	{
		$ownerHolder = $this->loadObject($ownerHolder, $objectId);
		if (is_null($ownerHolder)) {
			$operContext->markNotFound();
			return null;
		}
		if (!$ownerHolder->getRole()->checkRole($rules->reqRole())) {
			$operContext->markDenied();
			return null;
		}
		return $actioner->runAction($this, $operContext, $ownerHolder);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		$this->appContainer = $appContainer;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	*/
	protected			$appContainer;
};


?>
