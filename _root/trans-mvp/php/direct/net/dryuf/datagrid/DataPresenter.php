<?php

namespace net\dryuf\datagrid;


class DataPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->options = $options;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			init()
	{
		parent::init();
		if (is_null($this->dataClass))
			$this->dataClass = $this->options->getOptionMandatory("dataClass");
		$this->dataName = str_replace(".", "_", $this->dataClass);
		$this->classMeta = \net\dryuf\app\ClassMetaManager::openCached($this->getCallerContext()->getAppContainer(), $this->dataClass, $this->dataView);
		$this->ownerHolder = \net\dryuf\core\EntityHolder::createRoleOnly($this->getCallerContext());
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDataProvider($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDataClassName()
	{
		return $this->dataClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			urlDisplayKey($entity)
	{
		return $this->classMeta->urlDisplayKey($this->callerContext, $entity);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			urlPkEntityKey($pk)
	{
		return $this->classMeta->urlPkEntityKey($this->getCallerContext(), $pk);
	}

	/**
	 * Formats external entity.
	 * 
	 * @param refKey
	 * 	key of referenced entity
	 * @param refClass
	 * 	class of referenced entity
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatExternal($refKey, $refClass)
	{
		$refProvider = $this->getCallerContext()->getBean($refClass."-dao");
		$refMeta = \net\dryuf\app\ClassMetaManager::openCached($this->callerContext->getAppContainer(), $refClass, "Default");
		$refObject = $refProvider->retrieveDynamic(\net\dryuf\core\EntityHolder::createRoleOnly($this->getCallerContext()), $refKey);
		$refEntity = $refObject->getEntity();
		$formatted = null;
		foreach ($refMeta->getRefFields() as $refFieldName) {
			$refFdef = $refMeta->getField($refFieldName);
			if (is_null($formatted))
				$formatted = new \net\dryuf\core\StringBuilder();
			else
				$formatted->append(" ");
			$formatted->append(\net\dryuf\textual\TextualManager::formatTextualUnsafe($refFdef->needTextual(), $this->getCallerContext(), $refMeta->getEntityFieldValue($refEntity, $refFieldName)));
		}
		return strval($formatted);
	}

	/**
	 * Formats reference.
	 * 
	 * @param entity
	 * 	entity
	 * @param fdef
	 * 	field definition to be formatted
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatRef($entity, $fdef)
	{
		$refPk = $this->classMeta->getEntityFieldValue($entity, $fdef->getName());
		if (is_null($fdef->getAssocClass()))
			throw new \net\dryuf\core\RuntimeException("Field ".$fdef->getName()." does not have association definition");
		$refMeta = \net\dryuf\app\ClassMetaManager::openCached($this->getCallerContext()->getAppContainer(), $fdef->getAssocClass(), "Default");
		$refProvider = $this->getCallerContext()->getBean($refMeta->getDataClassName()."-dao");
		$refObject = $refProvider->retrieveDynamic(\net\dryuf\core\EntityHolder::createRoleOnly($this->getCallerContext()), $refPk);
		if (is_null($refObject))
			return null;
		$refEntity = $refObject->getEntity();
		$formatted = null;
		foreach ($refMeta->getRefFields() as $refFieldName) {
			$refFdef = $refMeta->getField($refFieldName);
			if (is_null($formatted))
				$formatted = new \net\dryuf\core\StringBuilder();
			else
				$formatted->append(" ");
			$formatted->append(\net\dryuf\textual\TextualManager::formatTextualUnsafe($refFdef->needTextual(), $this->getCallerContext(), $refMeta->getEntityFieldValue($refEntity, $refFieldName)));
		}
		return strval($formatted);
	}

	/**
	 * Formats reference.
	 * 
	 * @param entity
	 * 	entity
	 * @param fieldName
	 * 	field name to be formatted
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatRefName($entity, $fieldName)
	{
		return $this->formatRef($entity, $this->classMeta->getField($fieldName));
	}

	/**
	 * Formats value of specific field.
	 * 
	 * @param entity
	 * 	entity
	 * @param fdef
	 * 	field definition
	 * 
	 * @return
	 * 	formatted value
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatValue($entity, $fdef)
	{
		$internal = $this->classMeta->getEntityFieldValue($entity, $fdef->getName());
		return is_null($internal) ? "" : \net\dryuf\textual\TextualManager::formatTextualUnsafe($fdef->needTextual(), $this->getCallerContext(), $internal);
	}

	/**
	 * Formats value of specific field.
	 * 
	 * @param entity
	 * 	entity
	 * @param fieldName
	 * 	field name
	 * 
	 * @return
	 * 	formatted value
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatValueName($entity, $fieldName)
	{
		return $this->formatValue($entity, $this->classMeta->getField($fieldName));
	}

	/**
	 * Formats single child.
	 * 
	 * @param child
	 * 	child entity
	 * @param childClass
	 * 	child class
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatChild($child, $childClass)
	{
		$childMeta = \net\dryuf\app\ClassMetaManager::openCached($this->getCallerContext()->getAppContainer(), $childClass, "Default");
		return strval($this->formatChildInternal($child, $childMeta, null));
	}

	/**
	 * Formats single child, internal implementation.
	 * 
	 * @param child
	 * 	child entity
	 * @param childMeta
	 * 	child class meta information
	 * @param formatted
	 * 	formatted string
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	public function			formatChildInternal($child, $childMeta, $formatted)
	{
		foreach ($childMeta->getFields() as $fdef) {
			if ($fdef->getAssocType() == \net\dryuf\app\FieldDef::AST_Compos)
				continue;
			$value = $childMeta->getEntityFieldValue($child, $fdef->getName());
			if (!is_null($fdef->getEmbedded())) {
				$formatted = $this->formatChildInternal($value, $fdef->getEmbedded(), $formatted);
			}
			else {
				if (is_null($formatted))
					$formatted = new \net\dryuf\core\StringBuilder();
				else
					$formatted->append(" ");
				if ($fdef->getAssocType() == \net\dryuf\app\FieldDef::AST_Reference) {
					$formatted->append($this->formatExternal($value, $fdef->getAssocClass()));
				}
				else {
					$formatted->append(\net\dryuf\textual\TextualManager::formatTextualUnsafe($fdef->needTextual(), $this->getCallerContext(), $value));
				}
			}
		}
		return $formatted;
	}

	/**
	 * Formats children contained in field.
	 * 
	 * @param entity
	 * 	entity
	 * @param fdef
	 * 	field definition
	 * 
	 * @return
	 * 	list of formatted entities
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			formatChildrenList($entity, $fdef)
	{
		$internal = $this->classMeta->getEntityFieldValue($entity, $fdef->getName());
		if ($internal->size() > 0) {
			if ($internal->iterator()->next() instanceof \java\lang\Comparable) {
				$sorted = new \net\dryuf\util\LinkedList();
				$sorted->addAll($internal);
				\net\dryuf\util\Collections::sort($sorted);
				$internal = $sorted;
			}
			return \net\dryuf\util\Collections::transform($internal, 
				function ($child) use ($fdef) {
					return $this->formatChild($child, $fdef->getAssocClass());
				}
			);
		}
		else {
			return $internal;
		}
	}

	/**
	 * Formats children list contained in field.
	 * 
	 * @param entity
	 * 	entity
	 * @param fieldName
	 * 	field name
	 * 
	 * @return
	 * 	list of formatted entities
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			formatChildrenListName($entity, $fieldName)
	{
		return $this->formatChildrenList($entity, $this->classMeta->getField($fieldName));
	}

	/**
	 * Formats children list contained in field, concatenating using separator.
	 * 
	 * @param entity
	 * 	entity
	 * @param fdef
	 * 	field definition
	 * @param separator
	 * 	separator used to join entities
	 * 
	 * @return
	 * 	single string of concatenated entities
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatChildren($entity, $fdef, $separator)
	{
		return \net\dryuf\core\StringUtil::join($separator, $this->formatChildrenList($entity, $fdef));
	}

	/**
	 * Formats children list contained in field, concatenating using separator.
	 * 
	 * @param entity
	 * 	entity
	 * @param fieldName
	 * 	field name
	 * @param separator
	 * 	separator used to join entities
	 * 
	 * @return
	 * 	single string of concatenated entities
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatChildrenName($entity, $fieldName, $separator)
	{
		return $this->formatChildren($entity, $this->classMeta->getField($fieldName), $separator);
	}

	/**
	 * Formats field.
	 * 
	 * @param entity
	 * 	entity
	 * @param fdef
	 * 	field definition
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatField($entity, $fdef)
	{
		if ($fdef->getAssocType() == \net\dryuf\app\FieldDef::AST_Children) {
			return $this->formatChildren($entity, $fdef, ", ");
		}
		elseif (!is_null($fdef->getAssocClass())) {
			return $this->formatRef($entity, $fdef);
		}
		else {
			return $this->formatValue($entity, $fdef);
		}
	}

	/**
	 * Formats field.
	 * 
	 * @param entity
	 * 	entity
	 * @param fieldName
	 * 	field name
	 * 
	 * @return
	 * 	formatted entity
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatFieldName($entity, $fieldName)
	{
		return $this->formatField($entity, $this->classMeta->getField($fieldName));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	public function			getGlobalActionList()
	{
		return $this->classMeta->getGlobalActionList($this->getCallerContext());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			readDisplayKey($first)
	{
		$keys = new \net\dryuf\util\LinkedList();
		foreach ($this->classMeta->getDisplayKeys() as $key) {
			if (is_null($first)) {
				if (is_null(($first = $this->getRootPresenter()->getPathElement()))) {
					$this->createNotFoundPresenter();
					return null;
				}
				elseif (is_null($this->rootPresenter->needPathSlash(true))) {
					new \net\dryuf\mvp\FalseDummyPresenter($this);
					return null;
				}
			}
			$keys->add($first);
			$first = null;
		}
		return $keys->toArray(\net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			loadByDisplayKey($keys)
	{
		$keyIdx = 0;
		$filter = new \net\dryuf\util\php\StringNativeHashMap();
		foreach ($this->classMeta->getDisplayKeys() as $fieldName) {
			$fdef = $this->classMeta->getField($fieldName);
			$filter->put($fdef->getName(), \net\dryuf\textual\TextualManager::convertTextualUnsafe($fdef->needTextual(), $this->getCallerContext(), $keys[$keyIdx++]));
		}
		$objects = new \net\dryuf\util\LinkedList();
		$this->dataProvider->listDynamic($objects, $this->ownerHolder, $filter, null, null, null);
		return $objects->size() != 0 ? $objects->get(0) : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			loadList()
	{
		$this->dataProvider->keepContextTransaction($this->getCallerContext());
		$this->listData = new \net\dryuf\util\LinkedList();
		return $this->dataProvider->listDynamic($this->listData, $this->ownerHolder, $this->listFilter, $this->listOrder, $this->listPageNum*$this->listPageSize, $this->listPageSize);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			loadingSingle($displayKey)
	{
		$this->dataProvider->keepContextTransaction($this->getCallerContext());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			loadingAction($displayKey, $action)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, net\dryuf\util\Listable<net\dryuf\core\EntityHolder<java\lang\Object>>, java\lang\Object>')
	*/
	public function			forceModelList($list)
	{
		$this->listData = $list;
		return $this->setRenderingList();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			removeObject($role, $key)
	{
		return $this->dataProvider->deleteDynamic(\net\dryuf\core\EntityHolder::createRoleOnly($role), $key);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createModeOper($mode)
	{
		return new \net\dryuf\datagrid\DataPresenter_ModeOper($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createModeList($mode)
	{
		return new \net\dryuf\datagrid\DataPresenter_ModeList($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createModeCreate($mode)
	{
		return new \net\dryuf\datagrid\DataPresenter_ModeCreate($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createModeInfo($mode)
	{
		return new \net\dryuf\datagrid\DataPresenter_ModeInfo($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createModeEdit($mode)
	{
		return new \net\dryuf\datagrid\DataPresenter_ModeEdit($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createModeRemove($mode)
	{
		return new \net\dryuf\datagrid\DataPresenter_ModeRemove($this, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			createModeInfoAndProcessLast()
	{
		$rootPresenter = $this->getRootPresenter();
		$rootPresenter->putBackLastElement();
		return $this->createModeInfo("info")->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$this->relativeUrl = $this->getRootPresenter()->getReversePath();
		return parent::process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		if (substr($element, 0, strlen("-")) == "-") {
			if (($element === "-page-")) {
				$this->getRootPresenter()->putBackLastElement();
				return $this->processMode("list");
			}
			elseif (($element === "-new-")) {
				return $this->processMode("new");
			}
			elseif (($element === "-oper-")) {
				return $this->processMode("oper");
			}
		}
		if (is_null(($displayKey = $this->readDisplayKey($element))) && !is_null($this->getLeadChild())) {
			return $this->getLeadChild()->process();
		}
		elseif (is_null($this->getRootPresenter()->needPathSlash(true))) {
			return false;
		}
		if (!is_null(($action = $this->rootPresenter->getPathElement()))) {
			$this->loadingAction($displayKey, $action);
		}
		else {
			$this->loadingSingle($displayKey);
		}
		if (!is_null(($obj = $this->loadByDisplayKey($displayKey)))) {
			$this->currentObject = $obj;
			if (!is_null($action)) {
				return $this->processObjectAction($action);
			}
			else {
				return $this->processObjectMode($this->getRequest()->getParamDefault("mode", "info"));
			}
		}
		else {
			return $this->processRootAction($element);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processObjectMode($mode)
	{
		switch ($mode) {
		case "info":
		case "edit":
		case "remove":
			return $this->processMode($mode);

		default:
			return $this->processObjectOther($mode);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processObjectAction($action)
	{
		return $this->createModeInfoAndProcessLast();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processObjectOther($mode)
	{
		return $this->createDefaultPresenter()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processRootAction($element)
	{
		return $this->createNotFoundPresenter()->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		return $this->processMode("list");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMode($mode)
	{
		$this->mode = $mode;
		switch ($this->mode) {
		case "oper":
			$this->modePresenter = $this->createModeOper($this->mode);
			break;

		case "list":
			$this->modePresenter = $this->createModeList($this->mode);
			break;

		case "info":
			$this->modePresenter = $this->createModeInfo($this->mode);
			break;

		case "edit":
			$this->modePresenter = $this->createModeEdit($this->mode);
			break;

		case "new":
			$this->modePresenter = $this->createModeCreate($this->mode);
			break;

		case "remove":
			$this->modePresenter = $this->createModeRemove($this->mode);
			break;

		default:
			throw new \net\dryuf\core\RuntimeException("invalid mode specified for DataPresenter: ".$this->mode);
		}
		return $this->modePresenter->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatKey($entity)
	{
		$sb = new \net\dryuf\core\StringBuilder();
		foreach ($this->classMeta->getAdditionalPkFields() as $pk) {
			$fdef = $this->classMeta->getField($pk);
			$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($fdef->needTextual(), $this->getCallerContext());
			$sb->append("_")->append($textual->formatKey($this->classMeta->getEntityFieldValue($entity, $pk)));
		}
		return strval($sb->replace(0, 1, ""));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			convertKey($text)
	{
		$text .= "_";
		$key = new \net\dryuf\util\php\StringNativeHashMap();
		foreach ($this->classMeta->getAdditionalPkFields() as $pk) {
			$fdef = $this->classMeta->getField($pk);
			$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($fdef->needTextual(), $this->getCallerContext());
			if (is_null(($match = \net\dryuf\core\StringUtil::matchText("^_([^_]*)(.*)\$", $text))))
				throw new \net\dryuf\core\RuntimeException("failed to convert key ".$text." from object ".$this->dataClass);
			$key->put($fdef->getName(), $textual->convertKey($match[1]));
			$text = $match[2];
		}
		return $key;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, net\dryuf\util\Listable<net\dryuf\core\EntityHolder<java\lang\Object>>, java\lang\Object>')
	*/
	public function			setRenderingList()
	{
		return $this->setRendering(new \net\dryuf\datagrid\ListRenderer());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, net\dryuf\core\EntityHolder<java\lang\Object>, java\lang\Object>')
	*/
	public function			setRenderingInfo()
	{
		return $this->setRendering(new \net\dryuf\datagrid\InfoRenderer());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, net\dryuf\core\EntityHolder<java\lang\Object>, java\lang\Object>')
	*/
	public function			setRenderingEdit()
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, net\dryuf\core\EntityHolder<java\lang\Object>, java\lang\Object>')
	*/
	public function			setRenderingCreate()
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, net\dryuf\core\EntityHolder<java\lang\Object>, java\lang\Object>')
	*/
	public function			setRenderingRemove()
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, java\lang\Object, java\lang\Object>')
	*/
	public function			setRendering($renderer)
	{
		$this->renderer = $renderer;
		return $this->renderer;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		if (!is_null($this->renderer)) {
			$this->rendererModel = $this->renderer->prepare($this, ($this->mode === "list") ? $this->listData : $this->currentObject);
		}
		else {
			parent::prepare();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if (!is_null($this->renderer)) {
			$this->renderer->render($this, ($this->mode === "list") ? $this->listData : $this->currentObject, $this->rendererModel);
		}
		else {
			parent::render();
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	protected			$options;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected			$ownerHolder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			getOwnerHolder()
	{
		return $this->ownerHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, java\lang\Object, java\lang\Object>')
	*/
	protected			$renderer;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenterRenderer<java\lang\Object, java\lang\Object, java\lang\Object>')
	*/
	public function			getRenderer()
	{
		return $this->renderer;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$rendererModel;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getRendererModel()
	{
		return $this->rendererModel;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$relativeUrl = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRelativeUrl()
	{
		return $this->relativeUrl;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRelativeUrl($relativeUrl_)
	{
		$this->relativeUrl = $relativeUrl_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$classMeta;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	public function			getClassMeta()
	{
		return $this->classMeta;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DynamicDao<java\lang\Object, java\lang\Object>')
	*/
	protected			$dataProvider;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DynamicDao<java\lang\Object, java\lang\Object>')
	*/
	public function			getDataProvider()
	{
		return $this->dataProvider;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	protected			$modePresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			getModePresenter()
	{
		return $this->modePresenter;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$mode;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMode()
	{
		return $this->mode;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$dataClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getDataClass()
	{
		return $this->dataClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenter<java\lang\Object>')
	*/
	public function			setDataClass($dataClass_)
	{
		$this->dataClass = $dataClass_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dataView = "Default";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDataView()
	{
		return $this->dataView;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenter<java\lang\Object>')
	*/
	public function			setDataView($dataView_)
	{
		$this->dataView = $dataView_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dataName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDataName()
	{
		return $this->dataName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$reqName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getReqName()
	{
		return $this->reqName;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$listFilter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getListFilter()
	{
		return $this->listFilter;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setListFilter($listFilter_)
	{
		$this->listFilter = $listFilter_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	protected			$listOrder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	public function			getListOrder()
	{
		return $this->listOrder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\core\EntityHolder<java\lang\Object>>')
	*/
	protected			$listData;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\core\EntityHolder<java\lang\Object>>')
	*/
	public function			getListData()
	{
		return $this->listData;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$listTotal = 0;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getListTotal()
	{
		return $this->listTotal;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setListTotal($listTotal_)
	{
		$this->listTotal = $listTotal_;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$listPageSize = 20;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getListPageSize()
	{
		return $this->listPageSize;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setListPageSize($listPageSize_)
	{
		$this->listPageSize = $listPageSize_;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$listPageNum = 0;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getListPageNum()
	{
		return $this->listPageNum;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setListPageNum($listPageNum_)
	{
		$this->listPageNum = $listPageNum_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected			$currentObject;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			getCurrentObject()
	{
		return $this->currentObject;
	}
};


?>
