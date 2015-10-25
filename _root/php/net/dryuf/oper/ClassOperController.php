<?php

namespace net\dryuf\oper;


class ClassOperController extends \net\dryuf\oper\DummyObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getObjectId($operContext)
	{
		return array();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\AbstractObjectOperController\Actioner')
	*/
	public function			findActioner($actionName)
	{
		if (!is_null(($actioner = parent::findActioner($actionName))))
			return $actioner;
		try {
			$actionController = $this->appContainer->getBean($actionName."-oper");
		}
		catch (\net\dryuf\core\NoSuchBeanException $ex) {
			throw new \RuntimeException("bad");
			return null;
		}
		return new \net\dryuf\oper\AbstractObjectOperController\ActionerImpl(
			$actionName,
			new \net\dryuf\oper\ObjectOperRules(array("value" => null, "isStatic" => true, "isFinal" => false)),
			function ($operContext, $ownerHolder) use ($actionController) { return $actionController->operate($operContext, $ownerHolder); }
		);
	}
}


?>
