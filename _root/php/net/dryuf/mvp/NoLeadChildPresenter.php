<?php

namespace net\dryuf\mvp;


class NoLeadChildPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		parent::__construct($parentPresenter_, self::$NOLEAD_OPTIONS);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public static			$NOLEAD_OPTIONS;

	public static function		_initManualStatic()
	{
		self::$NOLEAD_OPTIONS = \net\dryuf\core\Options::buildListed("nolead", true);
	}

};

\net\dryuf\mvp\NoLeadChildPresenter::_initManualStatic();


?>
