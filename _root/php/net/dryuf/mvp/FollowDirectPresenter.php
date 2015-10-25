<?php

namespace net\dryuf\mvp;


class FollowDirectPresenter extends \net\dryuf\mvp\proc\ResourcesPresenter
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
	public function			handlePathDirectory($path)
	{
		if ($this->resourceResolver->checkFileType($path."index.html") > 0)
			return $path."index.html";
		return parent::handlePathDirectory($path);
	}
};


?>
