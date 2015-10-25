<?php

namespace net\dryuf\xml\XmlMappedParser;


class XmlDynamicHandler extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($handlerObject, $startHandler, $endHandler, $childHandler)
	{
		parent::__construct();
		$this->handlerObject = $handlerObject;
		$this->startHandler = $startHandler;
		$this->endHandler = $endHandler;
		$this->childHandler = $childHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlDynamicHandler')
	*/
	public static function		create($clazz, $startHandler, $endHandler, $childHandler)
	{
		return new \net\dryuf\xml\XmlMappedParser\XmlDynamicHandler(null, \net\dryuf\core\Dryuf::getClassMethod($clazz, $startHandler, 'string', 'org\xml\sax\Attributes'), \net\dryuf\core\Dryuf::getClassMethod($clazz, $endHandler, 'string', 'org\xml\sax\Attributes'), \net\dryuf\core\Dryuf::getClassMethod($clazz, $childHandler, 'string', 'org\xml\sax\Attributes'));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getHandlerObject()
	{
		return $this->handlerObject;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$handlerObject;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getStartHandler()
	{
		return $this->startHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$startHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getEndHandler()
	{
		return $this->endHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$endHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getChildHandler()
	{
		return $this->childHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$childHandler;
};


?>
