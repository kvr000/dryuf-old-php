<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeList extends \net\dryuf\datagrid\DataPresenter_SubMode
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		if (!is_null($this->getLeadChild())) {
			return $this->getLeadChild()->process();
		}
		elseif (!is_null(($el = $this->getRootPresenter()->getPathElement()))) {
			if (($el === "-page-")) {
				return $this->processPage();
			}
			return $this->processMore($el);
		}
		else {
			return $this->processFinal();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processPage()
	{
		$this->rootPresenter = $this->getRootPresenter();
		if (is_null(($pageStr = $this->rootPresenter->getPathElement()))) {
			return $this->createNotFoundPresenter()->process();
		}
		$this->getDataPresenter()->setListPageNum(\net\dryuf\textual\TextualManager::convertTextual('net\dryuf\textual\PageNumberTextual', $this->getCallerContext(), $pageStr)-1);
		if (is_null($this->rootPresenter->needPathSlash(true))) {
			return false;
		}
		if (!$this->rootPresenter->needPathFinalParent()) {
			return true;
		}
		return $this->processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$request = $this->getRequest();
		$dataPresenter = $this->getDataPresenter();
		$dataPresenter->setListFilter(new \net\dryuf\util\php\StringNativeHashMap());
		foreach ($this->classMeta->getFields() as $fdef) {
			if (!is_null(($value = $request->getParamDefault($fdef->getName(), null)))) {
				$dataPresenter->getListFilter()->put($fdef->getName(), $this->classMeta->convertField($this->getCallerContext(), $fdef, $value));
			}
		}
		foreach ($this->classMeta->getFilterDefsHash()->values() as $filterDef) {
			if (!is_null(($value = $request->getParamDefault($filterDef->name(), null)))) {
				$dataPresenter->getListFilter()->put(":".$filterDef->name(), $value);
			}
		}
		$dataPresenter->setListTotal($dataPresenter->loadList());
		$dataPresenter->setRenderingList();
		return true;
	}
};


?>
