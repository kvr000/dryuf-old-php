<?php

namespace net\dryuf\datagrid;


abstract class SingleRenderer extends \net\dryuf\datagrid\DataPresenterRenderer
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
	public function			prepareObject(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $object, $carrier)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfo(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $object, $carrier)
	{
		$presenter->outputFormat("<table width=\"100%%\">\n");
		$this->renderInfoActions($presenter, $object, $carrier);
		$this->renderInfoContent($presenter, $object, $carrier);
		$presenter->outputFormat("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfoActions(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $object, $carrier)
	{
		$presenter->outputFormat("<tr><td>");
		$this->renderInfoActionsContent($presenter, $object, $carrier);
		$presenter->outputFormat("</td></tr>");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfoActionsContent(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $object, $carrier)
	{
		if ($object->checkAccess($presenter->getClassMeta()->getEntityRoles()->roleSet()))
			$presenter->outputFormat("<a href=\"?mode=edit\">%W</a> ", "net.dryuf.datagrid.DataPresenter", "Edit");
		if ($object->checkAccess($presenter->getClassMeta()->getEntityRoles()->roleDel()))
			$presenter->outputFormat("<a href=\"?mode=remove\">%W</a> ", "net.dryuf.datagrid.DataPresenter", "Remove");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderInfoContent(\net\dryuf\datagrid\DataPresenter $presenter, \net\dryuf\core\EntityHolder $object, $carrier)
	{
		$entity = $object->getEntity();
		foreach ($presenter->getClassMeta()->getFields() as $fdef) {
			$presenter->outputFormat("<tr><td class='key'>%W:</td><td>%S</td></tr>\n", $presenter->getDataClass(), $fdef->getName(), $presenter->formatField($entity, $fdef));
		}
	}
};


?>
