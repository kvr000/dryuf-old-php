<?php

namespace net\dryuf\security\admin\mvp;


class AdminPresenter extends \net\dryuf\mvp\DividerPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options, self::$divider);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	static				$divider;

	public static function		_initManualStatic()
	{
		self::$divider = new \net\dryuf\mvp\StaticPresenterDivider(
			array(
				\net\dryuf\mvp\PresenterElement::createClassed("", true, "admin", 'net\dryuf\security\admin\mvp\AdminMainPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("translation", true, "admin", 'net\dryuf\security\admin\mvp\AdminTranslationPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("roles", true, "admin", 'net\dryuf\security\admin\mvp\AdminRolesPresenter', \net\dryuf\core\Options::$NONE)
			));
	}

};

\net\dryuf\security\admin\mvp\AdminPresenter::_initManualStatic();


?>
