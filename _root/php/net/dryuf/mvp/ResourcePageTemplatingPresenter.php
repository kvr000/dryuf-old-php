<?php

namespace net\dryuf\mvp;


class ResourcePageTemplatingPresenter extends \net\dryuf\mvp\TemplatingPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->resourceName = $options->getOptionMandatory("resourceName");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			readResource()
	{
		return ($this->getCallerContext()->getAppContainer()->getCpResourceContent($this->resourceName));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$resourceName;
};


?>
