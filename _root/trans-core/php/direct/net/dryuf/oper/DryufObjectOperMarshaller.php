<?php

namespace net\dryuf\oper;


class DryufObjectOperMarshaller extends \net\dryuf\core\Object implements \net\dryuf\oper\ObjectOperMarshaller
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			prepareContent($content)
	{
		if (is_null($content)) {
			return null;
		}
		elseif ($content instanceof \net\dryuf\core\EntityHolder) {
			$eh = $content;
			$map = new \net\dryuf\util\php\StringNativeHashMap();
			$map->put("entity", \net\dryuf\validation\ObjectRoleUtil::getWithRole($eh->getEntity(), $eh->getRole()));
			$map->put("role", $eh->getRole()->getRoles());
			$map->put("view", $eh->getView());
			return $map;
		}
		elseif ($content instanceof \net\dryuf\core\CallerContext) {
			$role = $content;
			$map = new \net\dryuf\util\php\StringNativeHashMap();
			$map->put("role", $role->getRoles());
			return $map;
		}
		elseif ($content instanceof \net\dryuf\util\Listable) {
			$list = $content;
			$olist = new \net\dryuf\util\LinkedList();
			foreach ($list as $o) {
				$olist->add($this->prepareContent($o));
			}
			return $olist;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\SimpleListContainer) {
			$lc = $content;
			return $lc->entities;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\ListContainer) {
			$lc = $content;
			$map = new \net\dryuf\util\php\StringNativeHashMap();
			$map->put("total", $lc->total);
			$map->put("objects", $this->prepareContent($lc->objects));
			return $map;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\EntityContainer) {
			$ec = $content;
			return $this->prepareContent($ec->entityHolder);
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\SuccessContainer) {
			$sc = $content;
			return $sc->result;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\StringContainer) {
			$sc = $content;
			return $sc->content;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\ErrorContainer) {
			$sc = $content;
			$map = new \net\dryuf\util\php\StringNativeHashMap();
			$errors = new \net\dryuf\util\php\StringNativeHashMap();
			if ($sc->errors->getFieldErrorCount() != 0) {
				$map->put("_error", 412);
				foreach ($sc->errors->getFieldErrors() as $fieldError) {
					$errors->put($fieldError->getField(), $fieldError->getDefaultMessage());
				}
			}
			else {
				$map->put("_error", 413);
				$list = new \net\dryuf\util\LinkedList();
				$map->put("globals", $list);
				foreach ($sc->errors->getGlobalErrors() as $objectError) {
					$list->add($objectError->getDefaultMessage());
				}
			}
			$map->put("_errors", $errors);
			return $map;
		}
		else {
			throw new \net\dryuf\core\UnsupportedOperationException("cannot marshal unsafe object ".get_class($content));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputObject($operContext, $output)
	{
		$marshaller = $this->marshallers->get("json");
		try {
			$operContext->getResponse()->setContentType($marshaller->getMimeType());
			$marshaller->marshal($operContext->getResponse()->getOutputStream(), $this->prepareContent($output));
		}
		catch (\net\dryuf\core\RuntimeException $ex) {
			throw $ex;
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputUnauthorizedException($operContext, $ex)
	{
		$response = $operContext->getResponse();
		$response->sendError(401, null);
		$response->sendHeader("x-dryuf-conflict-cause", "UnauthorizedException");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputAccessValidationException($operContext, $ex)
	{
		$response = $operContext->getResponse();
		$response->sendError(409, "Access Denied");
		$response->sendHeader("x-dryuf-conflict-cause", "AccessValidationException");
		$response->sendHeader("x-dryuf-conflict-description", strval($ex));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputDataValidationException($operContext, $ex)
	{
		$response = $operContext->getResponse();
		$response->sendError(409, "Data Rejected");
		$response->sendHeader("x-dryuf-conflict-cause", "DataValidationException");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputUniqueValidationException($operContext, $ex)
	{
		$response = $operContext->getResponse();
		$response->sendError(409, "Unique Violation");
		$response->sendHeader("x-dryuf-conflict-cause", "UniqueValidationException");
		$response->sendHeader("x-dryuf-conflict-description", strval($ex));
		$response->sendHeader("x-dryuf-conflict-unique-key", $ex->getDataClass()."-".$ex->getConstraintName());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			preprocessInput($operContext)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	public function			getStaticOperMethod($operContext)
	{
		$request = $operContext->getRequest();
		$method = $request->getMethod();
		if (($method === "POST") && !is_null($request->getParam("_method"))) {
			$method = $request->getParam("_method");
		}
		$operation = null;
		$specmethodString = $request->getParam("_operation");
		if (!is_null($specmethodString)) {
			if (is_null(($operation = self::$operMap->get($specmethodString))))
				throw new \net\dryuf\core\RuntimeException("operation unsupported: ".$specmethodString);
		}
		switch ($method) {
		case "GET":
			if (!is_null($operation)) {
				switch ($operation) {
				case \net\dryuf\oper\ObjectOperMethod::LIST:
					$operContext->setHaveData(1);
					/* fall through */
				case \net\dryuf\oper\ObjectOperMethod::META:
				case \net\dryuf\oper\ObjectOperMethod::ROLE:
					return $operation;

				default:
					throw new \net\dryuf\core\RuntimeException("unexpected operation for static oper: ".$operation);
				}
			}
			return \net\dryuf\oper\ObjectOperMethod::LIST;

		case "POST":
		case "PUT":
			if (!is_null($operation)) {
				switch ($operation) {
				case \net\dryuf\oper\ObjectOperMethod::LIST:
				case \net\dryuf\oper\ObjectOperMethod::SUGGEST:
				case \net\dryuf\oper\ObjectOperMethod::CREATE:
					$operContext->setHaveData(1);
					/* fall through */
				case \net\dryuf\oper\ObjectOperMethod::META:
				case \net\dryuf\oper\ObjectOperMethod::ROLE:
					return $operation;

				default:
					throw new \net\dryuf\core\RuntimeException("unknown operation: ".$operation);
				}
			}
			$operContext->setHaveData(1);
			return \net\dryuf\oper\ObjectOperMethod::CREATE;

		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unknown static operation used: ".$method);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	public function			getObjectOperMethod($operContext)
	{
		$request = $operContext->getRequest();
		$method = $request->getMethod();
		if (($method === "POST") && !is_null($request->getParam("_method"))) {
			$method = $request->getParam("_method");
		}
		$operation = null;
		$specmethodString = $request->getParam("_operation");
		if (!is_null($specmethodString)) {
			if (is_null(($operation = self::$operMap->get($specmethodString))))
				throw new \net\dryuf\core\RuntimeException("operation unsupported: ".$specmethodString);
		}
		switch ($method) {
		case "GET":
			return \net\dryuf\oper\ObjectOperMethod::RETRIEVE;

		case "PUT":
		case "PATCH":
			$operContext->setHaveData(1);
			return \net\dryuf\oper\ObjectOperMethod::UPDATE;

		case "POST":
			if (!is_null($operation)) {
				switch ($operation) {
				case \net\dryuf\oper\ObjectOperMethod::RETRIEVE:
					return $operation;

				default:
					throw new \net\dryuf\core\RuntimeException("unexpected operation for static oper: ".$operation);
				}
			}
			throw new \net\dryuf\core\RuntimeException("unexpected object oper method: ".$method.", operation empty");

		case "DELETE":
			return \net\dryuf\oper\ObjectOperMethod::DELETE;

		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unexpected object oper method: ".$method);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getInputData($operContext)
	{
		$request = $operContext->getRequest();
		if ($operContext->getHaveData() == 0)
			return new \net\dryuf\util\php\StringNativeHashMap();
		if (($request->getRequestContentType() === "multipart/form-data")) {
			$inputStream = \net\dryuf\io\IoUtil::openMemoryStream($request->getParam("_arg"));
		}
		else {
			$inputStream = $request->getInputStream();
		}
		try {
			$marshaller = $this->marshallers->get("json");
			return $marshaller->unmarshal($inputStream, 'net\dryuf\util\Map');
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getActionData($operContext, $actionClass)
	{
		$actionData = \net\dryuf\core\Dryuf::createClassArg0($actionClass);
		\net\dryuf\validation\DataValidatorUtil::validateWithNew($operContext->getCallerContext(), $actionData, \net\dryuf\util\MapUtil::getMapMandatory($operContext->getInputData(), "actionData"));
		return $actionData;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperContext\ListParams')
	*/
	public function			getListParams($operContext)
	{
		$listParams = new \net\dryuf\oper\ObjectOperContext\ListParams();
		$listParams->setOffset($operContext->getRequest()->getTextual("_offset", \net\dryuf\textual\TextualManager::createTextual('net\dryuf\textual\LongTextual', $operContext->getCallerContext())));
		$listParams->setLimit($operContext->getRequest()->getTextual("_limit", \net\dryuf\textual\TextualManager::createTextual('net\dryuf\textual\LongTextual', $operContext->getCallerContext())));
		$listParams->setFilters($operContext->getInputData()->get("_filters"));
		$listParams->setSorts($operContext->getInputData()->get("_sorts"));
		return $listParams;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getViewFilter($operContext, $filterClass)
	{
		$filter = \net\dryuf\core\Dryuf::createClassArg0($filterClass);
		\net\dryuf\validation\DataValidatorUtil::validateWithNew($operContext->getCallerContext(), $filter, \net\dryuf\util\MapUtil::getMapMandatory($operContext->getInputData(), "viewFilter"));
		return $filter;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setMarshallers($marshallers)
	{
		$this->marshallers = $marshallers;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\serialize\DataMarshaller>')
	*/
	protected			$marshallers;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\oper\ObjectOperMethod>')
	*/
	static				$operMap;

	public static function		_initManualStatic()
	{
		self::$operMap = \net\dryuf\util\MapUtil::createStringNativeHashMap("meta", \net\dryuf\oper\ObjectOperMethod::META, "create", \net\dryuf\oper\ObjectOperMethod::CREATE, "retrieve", \net\dryuf\oper\ObjectOperMethod::RETRIEVE, "update", \net\dryuf\oper\ObjectOperMethod::UPDATE, "delete", \net\dryuf\oper\ObjectOperMethod::DELETE, "list", \net\dryuf\oper\ObjectOperMethod::LIST, "role", \net\dryuf\oper\ObjectOperMethod::ROLE, "action", \net\dryuf\oper\ObjectOperMethod::ACTION, "suggest", \net\dryuf\oper\ObjectOperMethod::SUGGEST);
	}

};

\net\dryuf\oper\DryufObjectOperMarshaller::_initManualStatic();


?>
