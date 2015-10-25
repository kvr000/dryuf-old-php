<?php

namespace net\dryuf\mvp;


class BoolDummyPresenter extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter_, $processRet)
	{
		parent::__construct($parentPresenter_, \net\dryuf\core\Options::$NONE);
		$this->processRet = $processRet;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return $this->processRet;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$processRet = false;
};


?>
