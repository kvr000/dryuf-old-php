<?php

namespace net\dryuf\mvp\proc;


abstract class JsonCachedExport extends \net\dryuf\mvp\proc\CachedExport
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMimeType()
	{
		return "application/json; charset=UTF-8";
	}
};


?>
