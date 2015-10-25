<?php

namespace net\dryuf\datagrid;


abstract class DataPresenterRenderer extends \net\dryuf\mvp\AbstractStaticRenderer
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			createModel()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			prepare($presenter, $data)
	{
		$model = $this->createModel();
		$this->prepareData($presenter, $data, $model);
		return $model;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepareData(\net\dryuf\datagrid\DataPresenter $presenter, $data, $model)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getInfoCssClasses()
	{
		return "net-dryuf-datagrid-Renderer-info";
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render($presenter, $data, $model)
	{
		$this->renderData($presenter, $data, $model);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderData(\net\dryuf\datagrid\DataPresenter $presenter, $data, $model)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfo(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $obj, $model)
	{
		$presenter->outputFormat("<table width=\"100%%\" class=%A>\n", $this->getInfoCssClasses());
		$this->renderInfoActions($presenter, $obj, $model);
		$this->renderInfoContent($presenter, $obj, $model);
		$presenter->outputFormat("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfoActions(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $obj, $model)
	{
		$presenter->outputFormat("<tr><td>");
		$this->renderInfoActionsContent($presenter, $obj, $model);
		$presenter->outputFormat("</td></tr>");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfoActionsContent(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $obj, $model)
	{
		if ($obj->checkAccess($presenter->classMeta->getEntityRoles()->roleSet()))
			$presenter->outputFormat("<a href=\"?mode=edit\" class=\"action\">%W</a> ", 'net\dryuf\datagrid\DataPresenter', "Edit");
		if ($obj->checkAccess($presenter->classMeta->getEntityRoles()->roleDel()))
			$presenter->outputFormat("<a href=\"?mode=remove\" class=\"action\">%W</a> ", 'net\dryuf\datagrid\DataPresenter', "Remove");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfoContent(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $obj, $model)
	{
		$entity = $obj->getEntity();
		foreach ($presenter->classMeta->getFields() as $fdef) {
			$presenter->outputFormat("<tr><td class=\"key\">%W:</td><td class=\"value\">%S</td></tr>\n", $presenter->getDataClass(), $fdef->getName(), $presenter->formatField($entity, $fdef));
		}
	}
};


?>
