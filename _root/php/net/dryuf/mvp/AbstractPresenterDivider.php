<?php

namespace net\dryuf\mvp;


abstract class AbstractPresenterDivider extends \net\dryuf\core\Object implements \net\dryuf\mvp\PresenterDivider
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			tryPage($presenter)
	{
		return $this->tryPageConsumed($presenter, $presenter->getRootPresenter()->getPathElement());
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process($presenter)
	{
		return $this->processConsumed($presenter, $presenter->getRootPresenter()->getPathElement());
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processConsumed($presenter, $page)
	{
		if (!is_null(($subPresenter = $this->tryPageConsumed($presenter, $page)))) {
			return $subPresenter->process();
		}
		return $presenter->createNotFoundPresenter()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			tryLangConsumed($presenter, $page)
	{
		if (!is_null($page)) {
			if (!$presenter->getUiContext()->checkLanguage($page))
				return $presenter->createNotFoundPresenter();
			$presenter->getRootPresenter()->setRealPath("");
			$page = $presenter->getRootPresenter()->getPathElement();
		}
		else {
			$presenter->getRootPresenter()->setRealPath("");
		}
		$child = $this->tryPageConsumed($presenter, $page);
		return $child;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		setPresenterTitle($presenter, $page)
	{
		if (!is_null($this->pageLocalizeClass)) {
			if ($page === "") {
				$presenter->setTitle("");
			}
			else {
				if (!(($title = $presenter->localize($this->pageLocalizeClass, $page)) === ""))
					$presenter->setTitle($title);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$pageLocalizeClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\AbstractPresenterDivider')
	*/
	public function			setPageLocalizeClass($pageLocalizeClass_)
	{
		$this->pageLocalizeClass = $pageLocalizeClass_;
		return $this;
	}
};


?>
