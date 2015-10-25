<?php

namespace net\dryuf\oper;


class DummyObjectOperMarshaller extends \net\dryuf\core\Object implements \net\dryuf\oper\ObjectOperMarshaller
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
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputObject($operContext, $output)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
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
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperMethod')
	*/
	public function			getObjectOperMethod($operContext)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getInputData($operContext)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getActionData($operContext, $actionClass)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperContext\ListParams')
	*/
	public function			getListParams($operContext)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getViewFilter($operContext, $filterClass)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}
};


?>
