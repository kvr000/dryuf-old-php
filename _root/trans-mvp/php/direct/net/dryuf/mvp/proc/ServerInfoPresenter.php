<?php

namespace net\dryuf\mvp\proc;


class ServerInfoPresenter extends \net\dryuf\mvp\FinalEmptyXhtmlPresenter
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
		$this->outputFormat("%S\n", $this->getRequest()->getServletContext()->getServerInfo());
	}
};


?>
