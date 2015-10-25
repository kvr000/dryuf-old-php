<?php

namespace net\dryuf\oper;


class DaoObjectOperController extends \net\dryuf\oper\AbstractObjectOperController
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
		parent::afterAppContainer($appContainer);
		if (is_null($this->objectDao))
			throw new \net\dryuf\core\IllegalArgumentException("objectDao not specified");
		if (is_null($this->dataClass))
			$this->setDataClass($this->objectDao->getEntityClass());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDataClass($dataClass)
	{
		$this->dataClass = $dataClass;
		$this->dataMeta = \net\dryuf\app\ClassMetaManager::openCached(null, $dataClass, null);
		$this->dataPkClass = $this->dataMeta->getPkClass();
		if ($this->dataMeta->isPkEmbedded())
			$this->pkMeta = $this->dataMeta->getPkFieldDef()->getEmbedded();
		if ($this->dataMeta->hasCompos())
			$this->composMeta = \net\dryuf\app\ClassMetaManager::openCached(null, $this->dataMeta->getComposClass(), null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getDataClass()
	{
		return $this->dataClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setObjectDao($objectDao)
	{
		\net\dryuf\tenv\DAssert::assertNotNull($objectDao);
		$this->objectDao = $objectDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public function			getObjectId($operContext)
	{
		if (!$this->dataMeta->isPkEmbedded()) {
			return $this->getObjectIdList($operContext, 1);
		}
		else {
			return $this->getObjectIdList($operContext, count($this->dataMeta->getAdditionalPkFields()));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertStringToKeyField($keyClazz, $str)
	{
		return \net\dryuf\core\ConversionUtil::parseStringToClass($keyClazz, $str);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getDataPk($ownerHolder, $objectId)
	{
		if (!$this->dataMeta->isPkEmbedded()) {
			return $this->convertStringToKeyField($this->dataMeta->getPkFieldDef()->getType(), $objectId[0]);
		}
		else {
			$e = $this->dataMeta->instantiate();
			if (!is_null($this->composMeta))
				$this->dataMeta->setComposKey($e, $this->composMeta->getEntityPkValue($ownerHolder->getEntity()));
			$pk = $this->dataMeta->getEntityPkValue($e);
			for ($i = 0; $i < count($this->dataMeta->getAdditionalPkFields()); $i++) {
				$fd = $this->pkMeta->getPathField($this->dataMeta->getAdditionalPkFields()[$i]);
				$this->pkMeta->setEntityPathValue($pk, $this->dataMeta->getAdditionalPkFields()[$i], $this->convertStringToKeyField($fd->getType(), $objectId[$i]));
			}
			return $pk;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		keepContextTransaction($callerContext)
	{
		$this->objectDao->keepContextTransaction($callerContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	protected function		loadObject($ownerHolder, $objectId)
	{
		return $this->objectDao->retrieveDynamic($ownerHolder, $this->getDataPk($ownerHolder, $objectId));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			operateStaticMeta($operContext, $ownerHolder)
	{
		return \net\dryuf\oper\MetaExport::buildMeta($operContext->getCallerContext(), $this->dataClass, $operContext->getRequest()->getParamDefault("view", "Default"), $operContext->getRequest()->getContextPath()."/_oper/".$this->dataClass."/?");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticList($operContext, $ownerHolder)
	{
		$this->keepContextTransaction($ownerHolder->getRole());
		$out = new \net\dryuf\oper\ObjectOperController\ListContainer();
		$out->total = $this->executeStaticList($out->objects, $operContext, $ownerHolder, $operContext->getListParams());
		return $out;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			executeStaticList($results, $operContext, $ownerHolder, $listParams)
	{
		return $this->objectDao->listDynamic($results, $ownerHolder, $listParams->getFilters(), $listParams->getSorts(), $listParams->getOffset(), $listParams->getLimit());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticSuggest($operContext, $ownerHolder)
	{
		$out = new \net\dryuf\oper\ObjectOperController\ListContainer();
		$out->total = $this->executeStaticSuggest($out->objects, $operContext, $ownerHolder, $operContext->getListParams());
		return $out;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			executeStaticSuggest($results, $operContext, $ownerHolder, $listParams)
	{
		return $this->objectDao->listDynamic($results, $ownerHolder, $listParams->getFilters(), $listParams->getSorts(), $listParams->getOffset(), $listParams->getLimit());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateStaticCreate($operContext, $ownerHolder, $data)
	{
		if (!$ownerHolder->checkAccess($this->dataMeta->getEntityRoles()->roleNew())) {
			throw \net\dryuf\validation\AccessValidationException::createObjectException("Denied to new");
		}
		else {
			$prepared = $this->prepareStaticCreate($operContext, $ownerHolder, $data);
			$objectHolder = $this->executeStaticCreate($operContext, $ownerHolder, $data);
			$this->triggerStaticCreate($operContext, $objectHolder, $prepared);
			return $objectHolder;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			prepareStaticCreate($operContext, $ownerHolder, $inputData)
	{
		return $inputData;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			triggerStaticCreate($operContext, $objectHolder, $prepared)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			executeStaticCreate($operContext, $ownerHolder, $readValue)
	{
		try {
			return $this->objectDao->runTransactionedNew(
				function () use ($ownerHolder, $readValue) {
					$object = $this->objectDao->createDynamic($ownerHolder, $readValue);
					return $this->objectDao->retrieveDynamic($ownerHolder, $this->dataMeta->getEntityPkValue($object));
				}
			);
		}
		catch (\net\dryuf\core\RuntimeException $ex) {
			throw $ex;
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\AbstractObjectOperController\Actioner')
	*/
	public function			findActioner($actionName)
	{
		if (!is_null(($actioner = parent::findActioner($actionName))))
			return $actioner;
		$relationDef = $this->dataMeta->getRelation($actionName);
		if (!is_null($relationDef)) {
			try {
				$actionController = $this->appContainer->getBean($relationDef->targetClass()."-oper");
			}
			catch (\net\dryuf\core\NoSuchBeanException $ex) {
				return null;
			}
			return new \net\dryuf\oper\AbstractObjectOperController\ActionerImpl(
				$actionName,
				new \net\dryuf\oper\ObjectOperRules(array("value" => $actionName, "isStatic" => false, "isFinal" => false)),
				function ($operContext, $ownerHolder) use ($actionController) { return $actionController->operate($operContext, $ownerHolder); }
			);
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectUpdate($operContext, $objectHolder, $data)
	{
		if (!$objectHolder->checkAccess($this->dataMeta->getEntityRoles()->roleSet())) {
			throw \net\dryuf\validation\AccessValidationException::createObjectException("Denied to set");
		}
		else {
			try {
				$this->objectDao->runTransactionedNew(
					function () use ($operContext, $objectHolder, $data) {
						$prepared = $this->prepareObjectUpdate($operContext, $objectHolder, $data);
						$updatedObjectHolder = $this->executeObjectUpdate($operContext, $objectHolder, $data);
						$this->triggerObjectUpdate($operContext, $updatedObjectHolder, $prepared);
						return null;
					}
				);
				$this->objectDao->keepContextTransaction($operContext->getCallerContext());
				return $this->objectDao->retrieveDynamic($objectHolder, $this->dataMeta->getEntityPkValue($objectHolder->getEntity()));
			}
			catch (\net\dryuf\core\RuntimeException $ex) {
				throw $ex;
			}
			catch (\net\dryuf\core\Exception $e) {
				throw new \net\dryuf\core\RuntimeException($e);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			executeObjectUpdate($operContext, $objectHolder, $data)
	{
		try {
			$object = $this->objectDao->updateDynamic($objectHolder, $this->dataMeta->getEntityPkValue($objectHolder->getEntity()), $data);
			return $this->objectDao->retrieveDynamic($objectHolder, $this->dataMeta->getEntityPkValue($object));
		}
		catch (\net\dryuf\core\RuntimeException $ex) {
			throw $ex;
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			prepareObjectUpdate($operContext, $objectHolder, $inputData)
	{
		return $inputData;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			triggerObjectUpdate($operContext, $objectHolder, $prepared)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectRetrieve($operContext, $objectHolder)
	{
		return $objectHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			operateObjectDelete($operContext, $objectHolder)
	{
		if (!$objectHolder->checkAccess($this->dataMeta->getEntityRoles()->roleDel())) {
			throw \net\dryuf\validation\AccessValidationException::createObjectException("Denied to del");
		}
		else {
			try {
				return $this->objectDao->runTransactionedNew(
					function () use ($operContext, $objectHolder) {
						$prepared = $this->prepareObjectDelete($operContext, $objectHolder);
						$success = $this->executeObjectDelete($operContext, $objectHolder);
						if ($success) {
							$this->triggerObjectDelete($operContext, $objectHolder, $prepared);
						}
						return new \net\dryuf\oper\ObjectOperController\SuccessContainer($success);
					}
				);
			}
			catch (\net\dryuf\core\RuntimeException $ex) {
				throw $ex;
			}
			catch (\net\dryuf\core\Exception $e) {
				throw new \net\dryuf\core\RuntimeException($e);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			executeObjectDelete($operContext, $objectHolder)
	{
		return $this->objectDao->deleteDynamic($objectHolder, $this->dataMeta->getEntityPkValue($objectHolder->getEntity()));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			prepareObjectDelete($operContext, $objectHolder)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			triggerObjectDelete($operContext, $objectHolder, $prepared)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$dataClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$dataMeta;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$dataPkClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$pkMeta;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$composMeta;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DynamicDao<java\lang\Object, java\lang\Object>')
	*/
	protected			$objectDao;
};


?>
