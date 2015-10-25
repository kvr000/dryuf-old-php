<?php

namespace net\dryuf\mvp;


class GenericPageCodePresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->page = $options->getOptionDefault("page", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if (is_null($this->page)) {
			if (is_null(($this->page = $this->rootPresenter->needPathSlash(true))))
				return false;
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$page;
};


?>
