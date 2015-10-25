<?php

namespace net\dryuf\mvp;


class StaticPresenterDivider extends \net\dryuf\mvp\AbstractPresenterDivider
{
	/**
	*/
	function			__construct($elements)
	{
		parent::__construct();
		$this->divider = new \net\dryuf\util\php\StringNativeHashMap();
		foreach ($elements as $element) {
			$this->divider->put($element->getPage(), $element);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getPageList()
	{
		return $this->divider->keySet();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			checkPage($presenter, $page)
	{
		if (is_null($page))
			$page = "";
		$pageDef = $this->divider->get($page);
		if (is_null($pageDef))
			return 0;
		if (!$presenter->getCallerContext()->checkRole($pageDef->getRequiredRole())) {
			return -1;
		}
		return 1;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			tryPageConsumed($presenter, $page)
	{
		$rootPresenter = $presenter->getRootPresenter();
		if (is_null($page))
			$page = "";
		$pageDef = $this->divider->get($page);
		if (is_null($pageDef))
			return null;
		if (is_null($rootPresenter->needPathSlash($pageDef->getNeedSlash()))) {
			return new \net\dryuf\mvp\BoolDummyPresenter($presenter, !$pageDef->getNeedSlash());
		}
		elseif (!$presenter->getCallerContext()->checkRole($pageDef->getRequiredRole())) {
			return $presenter->createDeniedPresenter();
		}
		else {
			$child = call_user_func($pageDef->getCreator(), $presenter);
			$this->setPresenterTitle($presenter, $page);
			return $child;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\mvp\PresenterElement>')
	*/
	protected			$divider;
};


?>
