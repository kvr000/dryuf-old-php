<?php

namespace net\dryuf\mvp;


class LanguageWrapPresenterDivider extends \net\dryuf\mvp\AbstractPresenterDivider
{
	/**
	*/
	function			__construct($resourceDivider, $pageDivider)
	{
		parent::__construct();
		$this->resourceDivider = $resourceDivider;
		$this->pageDivider = $pageDivider;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getPageList()
	{
		return $this->pageDivider->getPageList();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			checkPage($presenter, $page)
	{
		return $this->pageDivider->checkPage($presenter, $page);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			tryPageConsumed($presenter, $page)
	{
		if (!is_null(($child = $this->resourceDivider->tryPageConsumed($presenter, $page))))
			return $child;
		return $this->pageDivider->tryLangConsumed($presenter, $page);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	protected			$resourceDivider;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	protected			$pageDivider;
};


?>
