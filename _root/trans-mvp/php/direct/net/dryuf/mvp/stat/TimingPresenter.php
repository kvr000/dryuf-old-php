<?php

namespace net\dryuf\mvp\stat;


class TimingPresenter extends \net\dryuf\mvp\NoLeadChildPresenter
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
	public function			render()
	{
		$this->outputFormat("<td>%Sms</td>", strval(intval(intval(microtime(true)*1000)-$this->getRootPresenter()->getStarted())));
	}
};


?>
