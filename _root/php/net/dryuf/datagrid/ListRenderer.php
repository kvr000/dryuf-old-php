<?php

namespace net\dryuf\datagrid;


class ListRenderer extends \net\dryuf\datagrid\DataPresenterRenderer
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
	public function			prepareData(\net\dryuf\datagrid\DataPresenter $presenter, $data, $carrier)
	{
		$i = 0;
		foreach ($data as $object) {
			$this->prepareObject($presenter, $object, $i, $carrier);
			$i++;
		}
		parent::prepareLeadChild($presenter);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepareObject($presenter, $object, $i, $carrier)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderData(\net\dryuf\datagrid\DataPresenter $presenter, $data, $carrier)
	{
		$this->renderList($presenter, $data, $carrier);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getListCss()
	{
		return "net-dryuf-datagrid-DataPresenter-list-behaviour";
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderList($presenter, $data, $carrier)
	{
		$presenter->outputFormat("<div class=%A>\n", $this->getListCss());
		$this->renderListInner($presenter, $data, $carrier);
		$presenter->output("</div>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListInner($presenter, $data, $carrier)
	{
		$presenter->outputFormat("<table class='controls'>\n");
		$this->renderListMainHead($presenter, $carrier);
		$presenter->outputFormat("</table>\n");
		$this->renderListTable($presenter, $data, $carrier);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListMainHead($presenter, $carrier)
	{
		$presenter->outputFormat("<tr>");
		$presenter->outputFormat("<td class='globalactions'>\n");
		$this->renderListGlobalActions($presenter, $presenter->getGlobalActionList(), $carrier);
		$presenter->outputFormat("</td>\n");
		$presenter->outputFormat("<td class='pager'>\n");
		$this->renderListPager($presenter, $carrier);
		$presenter->outputFormat("</td>\n");
		$presenter->outputFormat("<td class='command'>\n");
		$this->renderListCommand($presenter, $carrier);
		$presenter->outputFormat("</td>\n");
		$presenter->outputFormat("</tr>");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListGlobalActions($presenter, $actions, $carrier)
	{
		foreach ($actions as $action) {
			switch ($action->name()) {
			case "new":
				$presenter->outputFormat("<a class='action' href=\"%S-new-/\">%W</a> ", $presenter->getRelativeUrl(), $presenter->getDataClass(), $action->name());
				/* fall through */
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListPager($presenter, $carrier)
	{
		if ($presenter->getListPageSize() != 0) {
			$presenter->outputFormat("<form action=\".\">");
			$pages = new \net\dryuf\util\LinkedList();
			$pages->add($presenter->getListPageNum());
			$cont = true;
			for ($diff = 1, $step = 1; $cont; $diff += ($step = $step*2 > intval(intval($presenter->getListTotal()/$presenter->getListPageSize())/7) ? max(array((intval(intval($presenter->getListTotal()/$presenter->getListPageSize())/7)), 1)) : ($step*2))) {
				$cont = false;
				if ($diff < $presenter->getListPageNum()) {
					$cont = true;
					$pages->addIndexed(0, $presenter->getListPageNum()-$diff);
				}
				if ($diff < (intval(($presenter->getListTotal()-1)/$presenter->getListPageSize())-$presenter->getListPageNum())) {
					$cont = true;
					$pages->add($presenter->getListPageNum()+$diff);
				}
			}
			if ($presenter->getListPageNum() > 0) {
				$presenter->outputFormat("<a class='larr' href=\"%S-page-/%S\">◀</a> ", $presenter->getRelativeUrl(), \net\dryuf\net\util\UrlUtil::appendOptionalQuery($presenter->getListPageNum()."/", $presenter->getRequest()->getQueryString()));
				$pages->addIndexed(0, 0);
			}
			else {
				$presenter->output("<span class='larr'>◀</span> ");
			}
			if ($presenter->getListPageNum() < (intval(($presenter->getListTotal()-1)/$presenter->getListPageSize())))
				$pages->add((intval(($presenter->getListTotal()-1)/$presenter->getListPageSize())));
			$presenter->outputFormat("<select onchange='window.location=\"%S-page-/\"+(Number(this.value)+1)+\"/%S\";'>", $presenter->getRelativeUrl(), \net\dryuf\net\util\UrlUtil::appendOptionalQuery("", $presenter->getRequest()->getQueryString()));
			foreach ($pages as $page) {
				if ($page == $presenter->getListPageNum())
					$presenter->outputFormat("<option value=%A selected='selected'>%S</option>", strval($page), strval($page+1));
				else
					$presenter->outputFormat("<option value=%A>%S</option>", strval($page), strval($page+1));
			}
			$presenter->output("</select>");
			if ($presenter->getListPageNum() < intval(($presenter->getListTotal()-1)/$presenter->getListPageSize())) {
				$presenter->outputFormat(" <a class='rarr' href=\"%S-page-/%S\">▶</a>", $presenter->getRelativeUrl(), \net\dryuf\net\util\UrlUtil::appendOptionalQuery(($presenter->getListPageNum()+2)."/", $presenter->getRequest()->getQueryString()));
			}
			else {
				$presenter->output(" <span class='rarr'>▶</span>");
			}
			$presenter->output("</form>");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListCommand($presenter, $carrier)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListTable($presenter, $data, $carrier)
	{
		$fields = $presenter->getClassMeta()->getFields();
		$presenter->outputFormat("<table class='table' width=\"100%%\" border='1'>\n");
		$this->renderListHead($presenter, $fields, $carrier);
		$this->renderListContent($presenter, $data, $fields, $carrier);
		$presenter->output("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListHead($presenter, $fields, $carrier)
	{
		$presenter->outputFormat("<tr class='header'>\n");
		$presenter->outputFormat("<th class='actions'>");
		$presenter->outputFormat("</th>");
		foreach ($fields as $fdef) {
			if ($fdef->getAssocType() == \net\dryuf\app\FieldDef::AST_Children) {
			}
			elseif ((($fdef->getDisplay()) == null)) {
				throw new \net\dryuf\core\RuntimeException("Field ".$fdef."[name] does not have display set");
			}
			elseif (($fdef->getDisplay() === "hidden()")) {
				continue;
			}
			$presenter->outputFormat("<th class='field'>%W</th>", $presenter->getClassMeta()->getDataClass(), $fdef->getName());
		}
		$presenter->output("</tr>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListContent($presenter, $data, $fields, $carrier)
	{
		foreach ($data as $dataObject) {
			$this->renderListObject($presenter, $fields, $dataObject, $carrier);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListObject($presenter, $fields, $dataObject, $carrier)
	{
		$presenter->outputFormat("<tr class='row'><td class='objectactions'>");
		$this->renderListObjectActions($presenter, $dataObject, $carrier);
		$presenter->outputFormat("</td>");
		$this->renderListObjectData($presenter, $fields, $dataObject, $carrier);
		$presenter->outputFormat("</tr>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListObjectActions($presenter, $dataObject, $carrier)
	{
		$entity = $dataObject->getEntity();
		$presenter->outputFormat("<a class='action' href=\"%S%S\">%W</a> ", $presenter->getRelativeUrl(), $presenter->urlDisplayKey($entity), 'net\dryuf\datagrid\DataPresenter', "Detail");
		if ($dataObject->checkAccess($presenter->getClassMeta()->getEntityRoles()->roleSet()))
			$presenter->outputFormat("<a class='action' href=\"%S%S?mode=edit\">%W</a> ", $presenter->getRelativeUrl(), $presenter->urlDisplayKey($entity), 'net\dryuf\datagrid\DataPresenter', "Edit");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderListObjectData($presenter, $fields, $dataObject, $carrier)
	{
		$entity = $dataObject->getEntity();
		foreach ($fields as $fdef) {
			$presenter->outputFormat("<td class='field'>%S</td>", $presenter->formatField($entity, $fdef));
		}
	}
};


?>
