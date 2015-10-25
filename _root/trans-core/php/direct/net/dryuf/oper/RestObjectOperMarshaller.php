<?php

namespace net\dryuf\oper;


class RestObjectOperMarshaller extends \net\dryuf\core\Object implements \net\dryuf\oper\ObjectOperMarshaller
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
	public function			prepareContent($operContext, $content)
	{
		if (is_null($content)) {
			return null;
		}
		elseif ($content instanceof \net\dryuf\core\EntityHolder) {
			$eh = $content;
			return \net\dryuf\validation\ObjectRoleUtil::getWithRole($eh->getEntity(), $eh->getRole());
		}
		elseif ($content instanceof \net\dryuf\core\CallerContext) {
			return null;
		}
		elseif ($content instanceof \net\dryuf\util\Listable) {
			$list = $content;
			$olist = new \net\dryuf\util\LinkedList();
			foreach ($list as $o) {
				$olist->add($this->prepareContent($operContext, $o));
			}
			return $olist;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\SimpleListContainer) {
			$lc = $content;
			return $lc->entities;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\ListContainer) {
			$lc = $content;
			return $this->prepareContent($operContext, $lc->objects);
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\EntityContainer) {
			$ec = $content;
			return $this->prepareContent($operContext, $ec->entityHolder);
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\SuccessContainer) {
			$sc = $content;
			return $sc->result;
		}
		elseif ($content instanceof \net\dryuf\oper\ObjectOperController\ErrorContainer) {
			$sc = $content;
			$map = new \net\dryuf\util\php\StringNativeHashMap();
			$errors = new \net\dryuf\util\php\StringNativeHashMap();
			$operContext->getResponse()->sendError(412, "parameter errors");
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
			return $content;
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
			$marshaller->marshal($operContext->getResponse()->getOutputStream(), $this->prepareContent($operContext, $output));
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
		throw new \net\dryuf\core\UnsupportedOperationException("not implemented yet");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputAccessValidationException($operContext, $ex)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("not implemented yet");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputDataValidationException($operContext, $ex)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("not implemented yet");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputUniqueValidationException($operContext, $ex)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("not implemented yet");
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
		switch ($operContext->getRequest()->getMethod()) {
		case "GET":
			return \net\dryuf\oper\ObjectOperMethod::LIST;

		case "POST":
		case "PUT":
			return \net\dryuf\oper\ObjectOperMethod::CREATE;

		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unknown static operation used: ".$operContext->getRequest()->getMethod());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	public function			getObjectOperMethod($operContext)
	{
		switch ($operContext->getRequest()->getMethod()) {
		case "GET":
			return \net\dryuf\oper\ObjectOperMethod::RETRIEVE;

		case "POST":
		case "PUT":
		case "PATCH":
			return \net\dryuf\oper\ObjectOperMethod::UPDATE;

		case "DELETE":
			return \net\dryuf\oper\ObjectOperMethod::DELETE;

		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unknown object operation used: ".$operContext->getRequest()->getMethod());
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
		return $listParams;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getViewFilter($operContext, $filterClass)
	{
		return null;
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
};


?>
