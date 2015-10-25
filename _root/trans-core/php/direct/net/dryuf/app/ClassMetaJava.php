<?php

namespace net\dryuf\app;


class ClassMetaJava extends \net\dryuf\core\Object implements \net\dryuf\app\ClassMeta
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	public static function		openCached($appContainer, $dataClass, $dataView)
	{
		if (is_null($dataView))
			$dataView = "Default";
		$full = $dataClass."-".$dataView;
		$meta = self::$cachedData->get($full);
		if (is_null($meta)) {
			$meta = new \net\dryuf\app\ClassMetaJava($dataClass, $dataView);
			$meta->parseDataDescription();
			self::$cachedData->put($full, $meta);
		}
		return $meta;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMetaJava<java\lang\Object>')
	*/
	public static function		openEmbedded($appContainer, $dataClass, $basePath, $composPath)
	{
		$meta = new \net\dryuf\app\ClassMetaJava($dataClass, null);
		$meta->basePath = $basePath;
		$meta->embedded = true;
		$meta->composPath = $composPath;
		$meta->parseDataDescription();
		return $meta;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		refresh()
	{
		self::$cachedData->clear();
	}

	/**
	*/
	function			__construct($dataClass, $dataView)
	{
		parent::__construct();
		$this->dataClass = $dataClass;
		$this->dataView = $dataView;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertField($callerContext, $fdef, $value)
	{
		$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($fdef->needTextual(), $callerContext);
		return $textual->convert($value, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDataClassName()
	{
		return $this->getDataClass();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			instantiate()
	{
		try {
			return \net\dryuf\core\Dryuf::createClassArg0($this->dataClass);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::translateException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			canNew($callerContext)
	{
		return $callerContext->checkRole($this->entityRoles->roleNew());
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			canDel($callerContext)
	{
		return $callerContext->checkRole($this->entityRoles->roleDel());
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			hasCompos()
	{
		return !is_null($this->composPath);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>')
	*/
	public function			getPkFieldDef()
	{
		return $this->pkFieldDef;
	}

	/**
	 * @return
	 * 	list of additional PK fields within
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getAdditionalPkFields()
	{
		return $this->pkeyDef->additionalPkFields();
	}

	/**
	 * Gets list of field definitions.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>[]')
	*/
	public function			getFields()
	{
		return $this->fieldDefs;
	}

	/**
	 * Gets the field name of the key.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRefName()
	{
		return $this->pkeyDef->pkField();
	}

	/**
	 * Gets object key from the existing object.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getEntityPkValue($entity)
	{
		return $this->pkFieldDef->getValue($entity);
	}

	/**
	 * Sets object key.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEntityPkValue($entity, $value)
	{
		$this->pkFieldDef->setValue($entity, $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setComposKey($entity, $composKey)
	{
		if (!is_null($this->composBaseField->getEmbedded())) {
			$this->composBaseField->getEmbedded()->setComposKey($this->composBaseField->getValue($entity), $composKey);
		}
		else {
			$this->composBaseField->setValue($entity, $composKey);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getComposKey($entity)
	{
		if (!is_null($this->composBaseField->getEmbedded())) {
			return $this->composBaseField->getEmbedded()->getComposKey($this->composBaseField->getValue($entity));
		}
		else {
			return $this->composBaseField->getValue($entity);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef[]')
	*/
	public function			getActions()
	{
		return $this->actionDefs;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	public function			getFieldRoles($name)
	{
		$roles = $this->getField($name)->getRoles();
		if (is_null($roles))
			$roles = $this->getEntityRoles();
		return $roles;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>')
	*/
	public function			getField($name)
	{
		$fieldDef = $this->fieldDefsHash->get($name);
		if (is_null($fieldDef))
			throw new \net\dryuf\core\RuntimeException("asking for unknown field named ".$name);
		return $fieldDef;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getEntityFieldValue($entity, $fieldName)
	{
		$fieldDef = $this->getField($fieldName);
		if (true) {
			return \net\dryuf\app\ClassMetaJava::doGetObjectField($entity, $fieldDef);
		}
		else {
			return null;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEntityFieldValue($entity, $fieldName, $value)
	{
		$fieldDef = $this->getField($fieldName);
		if (true) {
			\net\dryuf\app\ClassMetaJava::doSetObjectField($entity, $fieldDef, $value);
		}
		else {
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>')
	*/
	public function			getPathField($path)
	{
		if (($p = \net\dryuf\core\StringUtil::indexOf($path, ".")) < 0) {
			return $this->getField($path);
		}
		else {
			$fieldDef = $this->getField(strval(substr($path, 0, $p)));
			return $fieldDef->getEmbedded()->getPathField(strval(substr($path, $p+1)));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getEntityPathValue($entity, $path)
	{
		if (($p = \net\dryuf\core\StringUtil::indexOf($path, ".")) < 0) {
			return $this->getEntityFieldValue($entity, $path);
		}
		else {
			$fieldDef = $this->getField(strval(substr($path, 0, $p)));
			return $fieldDef->getEmbedded()->getEntityPathValue($fieldDef->getValue($entity), strval(substr($path, $p+1)));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEntityPathValue($entity, $path, $value)
	{
		if (($p = \net\dryuf\core\StringUtil::indexOf($path, ".")) < 0) {
			$this->setEntityFieldValue($entity, $path, $value);
		}
		else {
			$fieldDef = $this->getField(strval(substr($path, 0, $p)));
			$fieldDef->getEmbedded()->setEntityPathValue($fieldDef->getValue($entity), strval(substr($path, $p+1)), $value);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\RelationDef')
	*/
	public function			getRelation($name)
	{
		return $this->relations->get($name);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef')
	*/
	public function			getAction($name)
	{
		$actionDef = $this->actionDefsHash->get($name);
		if (is_null($actionDef))
			throw new \net\dryuf\core\RuntimeException("asking for unknown action named ".$name);
		return $actionDef;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			urlDisplayKey($callerContext, $entity)
	{
		$sb = new \net\dryuf\core\StringBuilder();
		foreach ($this->getDisplayKeys() as $fieldPath) {
			$fieldDef = $this->getPathField($fieldPath);
			$sb->append(\net\dryuf\net\util\UrlUtil::encodeUrl(\net\dryuf\textual\TextualManager::formatTextual($fieldDef->needTextual(), $callerContext, $this->getEntityPathValue($entity, $fieldPath))))->append("/");
		}
		return strval($sb);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			urlPkEntityKey($callerContext, $pk)
	{
		try {
			$sb = new \net\dryuf\core\StringBuilder();
			if (!$this->pkEmbedded) {
				$fieldDef = $this->getField($this->pkeyDef->pkField());
				$sb->append(urlencode(\net\dryuf\textual\TextualManager::formatTextualUnsafe($fieldDef->needTextual(), $callerContext, $pk)))->append("/");
			}
			else {
				foreach ($this->getAdditionalPkFields() as $fieldName) {
					$fieldDef = $this->getField($fieldName);
					$sb->append(urlencode(\net\dryuf\textual\TextualManager::formatTextualUnsafe($fieldDef->needTextual(), $callerContext, \net\dryuf\core\Dryuf::getFieldValueNamed($pk, $fieldName))))->append("/");
				}
			}
			return strval($sb);
		}
		catch (\java\io\UnsupportedEncodingException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	public function			getGlobalActionList($callerContext)
	{
		$actions = new \net\dryuf\util\LinkedList();
		foreach ($this->actionDefs as $action) {
			if (!$action->isStatic())
				continue;
			if (!(($action->roleAction()) == null) && !$callerContext->checkRole($action->roleAction()))
				continue;
			$actions->add($action);
		}
		return $actions;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	public function			getObjectActionList($obj)
	{
		$actions = new \net\dryuf\util\LinkedList();
		foreach ($this->actionDefs as $action) {
			if ($action->isStatic())
				continue;
			if (!$obj->getRole()->checkRole($action->roleAction()))
				continue;
			$actions->add($action);
		}
		return $actions;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatAssocType($stype)
	{
		return self::$assocTypesStrings[$stype];
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected static function	doGetObjectField($o, $fieldDef)
	{
		if (!is_null($fieldDef->getGetter()))
			return \net\dryuf\core\Dryuf::invokeMethod($o, $fieldDef->getGetter());
		else
			return \net\dryuf\core\Dryuf::getFieldValue($o, $fieldDef->getField());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected static function	doSetObjectField($o, $fieldDef, $value)
	{
		if (!is_null($fieldDef->getSetter()))
			\net\dryuf\core\Dryuf::invokeMethod($o, $fieldDef->getSetter(), $value);
		else
			\net\dryuf\core\Dryuf::setFieldValue($o, $fieldDef->getField(), $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		parseDataDescription()
	{
		$this->fieldDefsHash = new \net\dryuf\util\php\StringNativeHashMap();
		$this->pkeyDef = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\PKeyDef');
		if (!is_null($this->pkeyDef)) {
			$this->pkEmbedded = $this->pkeyDef->pkEmbedded();
			$this->pkClass = $this->pkeyDef->pkClazz();
			if ((($this->pkName = $this->pkeyDef->pkField()) == null))
				$this->pkName = null;
			if ((($this->composPath = $this->pkeyDef->composPath()) == null))
				$this->composPath = null;
			if (($this->composClass = $this->pkeyDef->composClazz()) == 'void')
				$this->composClass = null;
			if (($this->composPkClass = $this->pkeyDef->composPkClazz()) == 'void')
				$this->composPkClass = null;
		}
		if (!$this->embedded) {
			foreach (\net\dryuf\core\Dryuf::getClassMandatoryAnnotation($this->dataClass, 'net\dryuf\meta\ViewsList')->views() as $viewCheck) {
				if (($viewCheck->name() === $this->dataView)) {
					$this->viewInfo = $viewCheck;
					break;
				}
			}
			if (is_null($this->viewInfo))
				throw new \net\dryuf\core\RuntimeException("no view named '".$this->dataView."' exists on ".$this->dataClass);
		}
		$this->relations = new \net\dryuf\util\php\StringNativeHashMap();
		$relationDefsAnno = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\RelationDefs');
		if (!is_null($relationDefsAnno)) {
			foreach ($relationDefsAnno->relations() as $relationDef)
				$this->relations->put($relationDef->name(), $relationDef);
		}
		$fieldDefsList = new \net\dryuf\util\LinkedList();
		$this->fieldOrder = (is_null($this->viewInfo) || count($this->viewInfo->fields()) == 1 && $this->viewInfo->fields()[0] === "") ? \net\dryuf\core\Dryuf::getClassMandatoryAnnotation($this->dataClass, 'net\dryuf\meta\FieldOrder')->fields() : $this->viewInfo->fields();
		$this->entityRoles = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\FieldRoles');
		foreach ($this->fieldOrder as $fieldName) {
			$fieldDef = new \net\dryuf\app\FieldDefImpl();
			$fieldDef->setName($fieldName);
			$fieldDef->setPath(is_null($this->basePath) ? $fieldName : ($this->basePath.$fieldName));
			try {
				$fieldDef->setField((=f_I_x=)dataClass.getDeclaredField(fieldName)(=x_I_f=));
			}
			catch (\java\lang\NoSuchFieldException $e) {
			}
			try {
				$fieldDef->setGetter((=f_I_x=)dataClass.getMethod("get" + StringUtil.capitalize(fieldName))(=x_I_f=));
			}
			catch (\java\lang\NoSuchMethodException $e) {
			}
			if (!is_null($fieldDef->getField())) {
				$fieldDef->setType((=f_I_x=)fieldDef.getField().getType()(=x_I_f=));
			}
			elseif (!is_null($fieldDef->getGetter())) {
				$fieldDef->setType((=f_I_x=)fieldDef.getGetter().getReturnType()(=x_I_f=));
			}
			else {
				throw new \net\dryuf\core\RuntimeException("no field nor getter defined for ".$this->dataClass.".".$fieldName);
			}
			try {
				$fieldDef->setSetter((=f_I_x=)dataClass.getMethod("set" + StringUtil.capitalize(fieldName), fieldDef.getType())(=x_I_f=));
			}
			catch (\java\lang\NoSuchMethodException $e) {
			}
			$assocDef = $this->getFieldDefAnnotation($fieldDef, 'net\dryuf\meta\AssocDef');
			if (!is_null($assocDef)) {
				$fieldDef->setAssocClass($assocDef->target());
			}
			$fieldDef->setReferenceDef($this->getFieldDefAnnotation($fieldDef, 'net\dryuf\meta\ReferenceDef'));
			if ($this->relations->containsKey($fieldName)) {
				$fieldDef->setAssocType(!is_null($assocDef) ? $assocDef->assocType() : \net\dryuf\app\FieldDef::AST_Children);
				$fieldDef->setTextual(null);
				$fieldDef->setDisplay(null);
				$fieldDef->setMandatory(false);
			}
			elseif (($fieldName === $this->composPath)) {
				$fieldDef->setAssocType(\net\dryuf\app\FieldDef::AST_Compos);
				$fieldDef->setTextual(null);
				$fieldDef->setDisplay(null);
				$fieldDef->setMandatory(true);
				$this->composBaseField = $fieldDef;
			}
			elseif (!is_null($this->getFieldDefAnnotation($fieldDef, 'javax\persistence\Embedded')) || !is_null($this->getFieldDefAnnotation($fieldDef, 'javax\persistence\EmbeddedId'))) {
				$isComposBase = !is_null($this->composPath) && substr($this->composPath, 0, strlen($fieldName)) == $fieldName && substr($this->composPath, strlen($fieldName), 1) == '.';
				$fieldDef->setEmbedded(\net\dryuf\app\ClassMetaJava::openEmbedded(null, $fieldDef->getType(), $fieldDef->getPath().".", $isComposBase ? strval(substr($this->composPath, strlen($fieldName)+1)) : null));
				$fieldDef->setDisplay(null);
				$fieldDef->setMandatory(false);
				if ($isComposBase)
					$this->composBaseField = $fieldDef;
			}
			else {
				$fieldDef->setAssocType(!is_null($assocDef) ? $assocDef->assocType() : \net\dryuf\app\FieldDef::AST_None);
				$fieldDef->setTextual($this->getFieldDefMandatoryAnnotation($fieldDef, 'net\dryuf\textual\TextualUse')->textual());
				$fieldDef->setAlign($this->getFieldDefMandatoryAnnotation($fieldDef, 'net\dryuf\textual\DisplayUse')->align());
				$fieldDef->setDisplay($this->getFieldDefMandatoryAnnotation($fieldDef, 'net\dryuf\textual\DisplayUse')->display());
				$mandatory = $this->getFieldDefMandatoryAnnotation($fieldDef, 'net\dryuf\meta\Mandatory');
				$fieldDef->setMandatory($mandatory->mandatory());
				$fieldDef->setDoMandatory(strlen($mandatory->doMandatory()) != 0 ? $mandatory->doMandatory() : null);
				$fieldDef->setReferenceDef($this->getFieldDefAnnotation($fieldDef, 'net\dryuf\meta\ReferenceDef'));
			}
			$fieldDef->setRoles(\net\dryuf\core\Dryuf::defvalue($this->getFieldDefAnnotation($fieldDef, 'net\dryuf\meta\FieldRoles'), $this->entityRoles));
			$this->fieldDefsHash->put($fieldName, $fieldDef);
			$fieldDefsList->add($fieldDef);
		}
		$this->fieldDefs = $fieldDefsList->toArray(self::$fieldDefEmptyArray);
		if (!is_null($this->pkName)) {
			if (is_null(($this->pkFieldDef = $this->fieldDefsHash->get($this->pkName))))
				throw new \net\dryuf\core\RuntimeException("cannot find pkField named ".$this->pkName." in class ".$this->dataClass);
		}
		if (!is_null($this->pkeyDef) && !is_null($this->composPath)) {
			$composField = $this->getPathField($this->composPath);
			$composField->setAssocType(\net\dryuf\app\FieldDef::AST_Compos);
			$composField->setAssocClass($this->composClass);
		}
		if (!is_null(($suggestDef = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\SuggestDef'))))
			$this->suggestFields = $suggestDef->fields();
		else
			$this->suggestFields = \net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY;
		if (!is_null(($refFieldsDef = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\RefFieldsDef'))))
			$this->refFields = $refFieldsDef->fields();
		else
			$this->refFields = \net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY;
		$actionDefsAnno = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\ActionDefs');
		$this->actionDefs = is_null($actionDefsAnno) ? array() : $actionDefsAnno->actions();
		$this->filterDefsHash = new \net\dryuf\util\php\StringNativeHashMap();
		$filterDefs = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\FilterDefs');
		if (!is_null($filterDefs)) {
			foreach ($filterDefs->filters() as $filterDef)
				$this->filterDefsHash->put($filterDef->name(), $filterDef);
		}
		$displayKeysDef = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\DisplayKeysDef');
		if (!is_null($displayKeysDef)) {
			$this->displayKeys = $displayKeysDef->fields();
		}
		elseif (!is_null($this->pkeyDef)) {
			if (!$this->pkEmbedded) {
				$this->displayKeys = array(
					$this->pkeyDef->pkField()
				);
			}
			else {
				$this->displayKeys = \net\dryuf\core\Dryuf::allocArray(null, count($this->pkeyDef->additionalPkFields()));
				for ($i = 0; $i < count($this->pkeyDef->additionalPkFields()); $i++) {
					$this->displayKeys[$i] = $this->pkeyDef->pkField().".".$this->pkeyDef->additionalPkFields()[$i];
				}
			}
		}
		else {
			$this->displayKeys = null;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\annotation\Annotation')
	*/
	protected function		getFieldDefAnnotation($fieldDef, $annotation)
	{
		if (!is_null($fieldDef->getField()) && !is_null(($a = (=f_I_x=)fieldDef.getField().getAnnotation(annotation)(=x_I_f=))))
			return $a;
		if (!is_null($fieldDef->getGetter()) && !is_null(($a = (=f_I_x=)fieldDef.getGetter().getAnnotation(annotation)(=x_I_f=))))
			return $a;
		if (!is_null($fieldDef->getSetter()) && !is_null(($a = (=f_I_x=)fieldDef.getSetter().getAnnotation(annotation)(=x_I_f=))))
			return $a;
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\annotation\Annotation')
	*/
	protected function		getFieldDefMandatoryAnnotation($fieldDef, $annotation)
	{
		$a = $this->getFieldDefAnnotation($fieldDef, $annotation);
		if (is_null($a))
			throw new \net\dryuf\core\RuntimeException("mandatory annotation not found on field ".$this->dataClass.".".$fieldDef->getName().": ".$annotation);
		return $a;
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
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dataView;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDataView()
	{
		return $this->dataView;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$embedded = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			getEmbedded()
	{
		return $this->embedded;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ViewInfo')
	*/
	protected			$viewInfo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ViewInfo')
	*/
	public function			getViewInfo()
	{
		return $this->viewInfo;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$pkClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getPkClass()
	{
		return $this->pkClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$pkName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPkName()
	{
		return $this->pkName;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$pkEmbedded = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isPkEmbedded()
	{
		return $this->pkEmbedded;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$composClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getComposClass()
	{
		return $this->composClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$composPkClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getComposPkClass()
	{
		return $this->composPkClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$composPath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getComposPath()
	{
		return $this->composPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	protected			$entityRoles;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	public function			getEntityRoles()
	{
		return $this->entityRoles;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>[]')
	*/
	protected			$fieldDefs;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\app\FieldDefImpl<java\lang\Object>>')
	*/
	protected			$fieldDefsHash;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\PKeyDef')
	*/
	protected			$pkeyDef;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dbSource;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDbSource()
	{
		return $this->dbSource;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dbTable;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDbTable()
	{
		return $this->dbTable;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef[]')
	*/
	protected			$actionDefs;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\ActionDef>')
	*/
	protected			$actionDefsHash;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$fieldOrder;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getFieldOrder()
	{
		return $this->fieldOrder;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$suggestFields;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getSuggestFields()
	{
		return $this->suggestFields;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$refFields;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getRefFields()
	{
		return $this->refFields;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$displayKeys;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getDisplayKeys()
	{
		return $this->displayKeys;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\RelationDef>')
	*/
	protected			$relations;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\RelationDef>')
	*/
	public function			getRelations()
	{
		return $this->relations;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	protected			$pkFieldDef;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	protected			$composBaseField;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$basePath;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\FilterDef>')
	*/
	protected			$filterDefsHash;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\FilterDef>')
	*/
	public function			getFilterDefsHash()
	{
		return $this->filterDefsHash;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>[]')
	*/
	static				$fieldDefEmptyArray;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\app\ClassMetaJava<java\lang\Object>>')
	*/
	static				$cachedData;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	static				$assocTypesStrings;

	public static function		_initManualStatic()
	{
		self::$fieldDefEmptyArray = array();
		self::$cachedData = new \net\dryuf\util\HashMap();
		self::$assocTypesStrings = array( "none", "compos", "reference", "children" );
	}

};

\net\dryuf\app\ClassMetaJava::_initManualStatic();


?>
