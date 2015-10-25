<?php

namespace net\dryuf\oper;


class ObjectOperContext extends \net\dryuf\core\Object implements \java\lang\AutoCloseable
{
	/**
	*/
	function			__construct($pageContext, $rootController, $ownerHolder)
	{
		parent::__construct();
		\net\dryuf\core\Dryuf::assertNotNull($rootController, "rootController");
		$this->pageContext = $pageContext;
		$this->rootController = $rootController;
		$this->ownerHolder = $ownerHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			close()
	{
		$this->pageContext->close();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	public function			getPageContext()
	{
		return $this->pageContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->pageContext->getCallerContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Request')
	*/
	public function			getRequest()
	{
		return $this->pageContext->getRequest();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Response')
	*/
	public function			getResponse()
	{
		return $this->pageContext->getResponse();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperContext')
	*/
	public function			setupObjectOperMarshaller($marshallerName)
	{
		if (is_null($marshallerName))
			$marshallerName = "default";
		$this->objectOperMarshaller = $this->pageContext->getCallerContext()->getBeanTyped('net\dryuf\oper\ObjectOperMarshaller'."-".$marshallerName, 'net\dryuf\oper\ObjectOperMarshaller');
		$this->objectOperMarshaller->preprocessInput($this);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$this->setupObjectOperMarshaller($this->getRequest()->getParamDefault("_servmarsh", "rest"));
		try {
			$result = $this->rootController->operate($this, $this->ownerHolder);
			if (is_null($result))
				return true;
			$this->outputObject($result);
		}
		catch (\net\dryuf\validation\DataValidationException $ex) {
			$this->getObjectOperMarshaller()->outputDataValidationException($this, $ex);
		}
		catch (\net\dryuf\validation\AccessValidationException $ex) {
			if ($this->getCallerContext()->isLoggedIn()) {
				$this->getObjectOperMarshaller()->outputAccessValidationException($this, $ex);
			}
			else {
				$this->getObjectOperMarshaller()->outputUnauthorizedException($this, $ex);
			}
		}
		catch (\net\dryuf\validation\UniqueValidationException $ex) {
			$this->getObjectOperMarshaller()->outputUniqueValidationException($this, $ex);
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateClass($dataClass)
	{
		$actionController = $this->getCallerContext()->getBean($dataClass."-oper");
		return $actionController->operate($this, \net\dryuf\core\EntityHolder::createRoleOnly($this->getCallerContext()));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputObject($output)
	{
		if ($output instanceof \net\dryuf\oper\ObjectOperController\SkipContainer)
			return;
		$this->getObjectOperMarshaller()->outputObject($this, $output);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			markError($errorStatus)
	{
		$this->errorStatus = $errorStatus;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			markNotFound()
	{
		$this->markError(404);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			markDenied()
	{
		$this->markError(401);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			hasError()
	{
		return $this->errorStatus != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPathElement()
	{
		return $this->pageContext->getPathElement();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			needPathSlash($needSlash)
	{
		if (!$this->pageContext->needPathSlash($needSlash)) {
			$this->markError(302);
			return false;
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	public function			getStaticOperMethod()
	{
		return $this->objectOperMarshaller->getStaticOperMethod($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	public function			getObjectOperMethod()
	{
		return $this->objectOperMarshaller->getObjectOperMethod($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getInputData()
	{
		if (is_null($this->inputData))
			$this->inputData = $this->objectOperMarshaller->getInputData($this);
		return $this->inputData;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getHaveData()
	{
		return $this->haveData;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setHaveData($haveData)
	{
		$this->haveData = $haveData;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getActionData($actionClass)
	{
		return $this->objectOperMarshaller->getActionData($this, $actionClass);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperContext\ListParams')
	*/
	public function			getListParams()
	{
		return $this->objectOperMarshaller->getListParams($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getViewFilter($filterClass)
	{
		return $this->objectOperMarshaller->getViewFilter($this, $filterClass);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMarshaller')
	*/
	public function			getObjectOperMarshaller()
	{
		return $this->objectOperMarshaller;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	protected			$pageContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController<java\lang\Object>')
	*/
	protected			$rootController;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected			$ownerHolder;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$errorStatus = 0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMarshaller')
	*/
	protected			$objectOperMarshaller;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$inputData;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$haveData = -1;
};


?>
