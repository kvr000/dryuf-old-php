<?php

namespace net\dryuf\mvp;


class ErrorPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct(\net\dryuf\mvp\Presenter $parentPresenter, \net\dryuf\core\Options $options)
	{
		parent::__construct($parentPresenter, $options);
		if ($this->getCallerContext()->getConfigValue("web.error.throw", 0) != 0) {
			throw new \net\dryuf\core\RuntimeException("error occurred");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<div class='msg_type_100'>%S</div>", $this->content);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$content;
};


?>
