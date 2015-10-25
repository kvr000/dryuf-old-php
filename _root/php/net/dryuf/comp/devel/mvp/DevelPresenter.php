<?php

namespace net\dryuf\comp\devel\mvp;


class DevelPresenter extends \net\dryuf\mvp\DividerPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options, self::$subPages);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	static				$subPages;

	public static function		_initManualStatic()
	{
		self::$subPages = new \net\dryuf\mvp\StaticPresenterDivider(
			array(
				\net\dryuf\mvp\PresenterElement::createClassed("files", true, "devel", 'net\dryuf\comp\devel\mvp\DevelFilesPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("sql", true, "devel", 'net\dryuf\comp\devel\mvp\DevelDryufSqlPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("", true, "devel", 'net\dryuf\mvp\JspPresenter', \net\dryuf\core\Options::$NONE)
			));
	}

};

\net\dryuf\comp\devel\mvp\DevelPresenter::_initManualStatic();


?>
