<?php

namespace net\dryuf\mvp;


class EmptyXhtmlPresenter extends \net\dryuf\mvp\MainXhtmlPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderBodyInner()
	{
		$this->renderMessages();
		$this->renderContent();
	}
};


?>
