<?php

namespace net\dryuf\menu\mvp;


class WebMenuPresenterDivider extends \net\dryuf\mvp\AbstractPresenterDivider implements \net\dryuf\core\AppContainerAware
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		if (is_null($this->webProvider))
			throw new \net\dryuf\core\IllegalArgumentException("webProvider not specified");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getPageList()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("not supported yet");
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			checkPage($presenter, $page)
	{
		if (is_null($page))
			$page = "";
		$impl = $this->webAccessiblePageDao->loadByPageCode($this->webProvider, $page);
		if (!is_null($impl)) {
			if (!$presenter->getCallerContext()->checkRole($impl->getReqRole())) {
				return -1;
			}
			else {
				return 1;
			}
		}
		else {
			return 0;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			tryPageConsumed($presenter, $page)
	{
		if (is_null($page))
			$page = "";
		$impl = $this->webAccessiblePageDao->loadByPageCode($this->webProvider, $page);
		if (!is_null($impl)) {
			if (is_null($presenter->getRootPresenter()->needPathSlash($impl->getNeedSlash())))
				return new \net\dryuf\mvp\BoolDummyPresenter($presenter, !$impl->getNeedSlash());
			if (!$presenter->getCallerContext()->checkRole($impl->getReqRole())) {
				return $presenter->createDeniedPresenter();
			}
			try {
				$child = \net\dryuf\mvp\Presenter::createSubPresenter($impl->getPresenterImpl(), $presenter, \net\dryuf\core\Options::$NONE);
			}
			catch (\net\dryuf\core\ClassNotFoundException $ex) {
				throw new \net\dryuf\core\RuntimeException($ex);
			}
			$this->setPresenterTitle($presenter, $page);
			return $child;
		}
		else {
			return null;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$webProvider;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setWebProvider($webProvider_)
	{
		$this->webProvider = $webProvider_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\dao\WebAccessiblePageDao')
	@\javax\inject\Inject
	*/
	protected			$webAccessiblePageDao;
};


?>
