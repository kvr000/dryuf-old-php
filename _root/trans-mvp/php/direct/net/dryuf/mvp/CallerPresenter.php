<?php

namespace net\dryuf\mvp;


class CallerPresenter extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		if (is_null(($this->method = $options->getOptionDefault("method", null))))
			$this->method = "process_".$parentPresenter->getRootPresenter()->getLastElementWithoutSlash();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return \net\dryuf\core\Dryuf::invokeMethodString0($this->parentPresenter, $this->method);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$method;
};


?>
