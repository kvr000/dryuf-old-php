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
		$this->outputFormat(
			"%S beans, %S classes, %S MB, %S ms",
			$this->getCallerContext()->getAppContainer()->getCreatedBeansCount(),
			strval(count(get_declared_classes())),
			number_format(memory_get_peak_usage()/1048576, 3, '.', ''), number_format((microtime(true)-$this->getRootPresenter()->getStarted())*1000, 3, '.', '')
		);
	}
};


?>
