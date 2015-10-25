<?php

namespace net\dryuf\mvp;


class AbstractStaticRenderer extends \net\dryuf\core\Object implements \net\dryuf\mvp\StaticRenderer
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			prepare($parentPresenter, $obj)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepareLeadChild($parentPresenter)
	{
		if (!is_null($parentPresenter->getLeadChild()))
			$parentPresenter->getLeadChild()->prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render($parentPresenter, $obj, $carrier)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderLeadChild($parentPresenter)
	{
		if (!is_null($parentPresenter->getLeadChild()))
			$parentPresenter->getLeadChild()->render();
	}
};


?>
