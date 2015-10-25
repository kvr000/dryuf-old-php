<?php

namespace net\dryuf\srvui\mock;


class MockRequest extends \net\dryuf\srvui\DummyRequest
{
	/**
	*/
	function			__construct($callerContext)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addFormObject($prefix, $form)
	{
		$meta = \net\dryuf\app\ClassMetaManager::openCached(null, get_class($form), null);
		foreach ($meta->getFields() as $fieldDef) {
			$value = $meta->getEntityFieldValue($form, $fieldDef->getName());
			$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($fieldDef->needTextual(), $this->callerContext);
			$this->addParam($prefix.$fieldDef->getName(), is_null($value) ? "" : $textual->format($value, null));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;
};


?>
