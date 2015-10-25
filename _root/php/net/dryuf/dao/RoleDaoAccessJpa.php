<?php

namespace net\dryuf\dao;


class RoleDaoAccessJpa extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($clazz, $entityManager)
	{
		parent::__construct();
		$this->dataClass = $clazz;
		$this->entityManager = $entityManager;
		$this->initInfo();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		initInfo()
	{
		$this->classMeta = \net\dryuf\app\ClassMetaManager::openCached(null, $this->dataClass, null);
		if (!is_null($this->classMeta->getComposClass())) {
			$this->composMeta = \net\dryuf\app\ClassMetaManager::openCached(null, $this->classMeta->getComposClass(), null);
			$this->composPath = $this->classMeta->getComposPath();
		}
		$this->pkClass = $this->classMeta->getPkClass();
		$this->pkName = $this->classMeta->getPkName();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\RoleProcessor<java\lang\Object>')
	*/
	public function			createRoleProcessor($baseContext)
	{
		$roleProcessorUse = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\dao\RoleProcessorUse');
		if (!is_null($roleProcessorUse)) {
			$roleProc = \net\dryuf\core\Dryuf::createClassArg2($roleProcessorUse->roleProcessor(), $baseContext, $this->dataClass);
		}
		else {
			$roleProc = new \net\dryuf\dao\AbstractRoleProcessor($baseContext, $this->dataClass);
		}
		return $roleProc;
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\persistence\Query')
	*/
	public function			createQuery($squery, $binds)
	{
		$bindargs = 0;
		for ($p = 0, $length = $squery->length(); $p < $length; ) {
			$quotePos = $squery->indexOf("'", $p);
			$questionPos = $squery->indexOf("?", $p);
			if ($quotePos >= 0 && ($questionPos < 0 || $quotePos < $questionPos)) {
				for ($p = $quotePos+1; $squery->charAt($p) != "'"; $p++) {
					if ($squery->charAt($p) == "\\")
						++$p;
				}
			}
			elseif ($questionPos >= 0) {
				$p = $questionPos+1;
				$squery->insert($p, ++$bindargs);
				$length = $squery->length();
			}
			else {
				break;
			}
		}
		\net\dryuf\tenv\DAssert::assertTrue($bindargs == count($binds), "binds count do not match");
		$ssquery = strval($squery);
		$query = $this->entityManager->createQuery($ssquery);
		for ($i = 0; $i < count($binds); $i++) {
			try {
				$query->setParameter($i+1, $binds[$i]);
			}
			catch (\net\dryuf\core\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("failed to bind ".$i." parameter for query: ".$ssquery, $ex);
			}
		}
		return $query;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getPkValue($object)
	{
		return $this->classMeta->getEntityPkValue($object);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			importClassDynamic($clazz, $data)
	{
		switch ($clazz) {
		case 'boolean':
		case 'java\lang\Boolean':
			return boolval($data);

		case 'int':
		case 'integer':
		case 'java\lang\Integer':
		case 'long':
		case 'java\lang\Long':
			return intval($data);

		case 'float':
		case 'double':
		case 'java\lang\Float':
		case 'java\lang\Double':
			return floatval($data);

		case 'string':
		case 'java\lang\String':
			return strval($data);

		default:
			$meta = \net\dryuf\app\ClassMetaManager::openCached(null, $clazz, null);
			$result = $meta->instantiate();
			$map = $data;
			foreach ($map->entrySet() as $entry) {
				$key = $entry->getKey();
				$fieldDef = $meta->getField($key);
				$meta->setEntityFieldValue($result, $entry->getKey(), $this->importClassDynamic($fieldDef->getType(), $entry->getValue()));
			}
			return $result;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			importDynamicKey($key)
	{
		return $this->importClassDynamic($this->pkClass, $key);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			exportDynamicData($holder)
	{
		return \net\dryuf\validation\ObjectRoleUtil::getWithRole($holder->getEntity(), $holder->getRole());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			exportEntityData($holder)
	{
		$result = new \net\dryuf\util\php\StringNativeHashMap();
		$result->put("role", $holder->getRole()->getRoles());
		$result->put("view", $holder->getView());
		$result->put("entity", \net\dryuf\validation\ObjectRoleUtil::getWithRole($holder->getEntity(), $holder->getRole()));
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\ViewSupplier<java\lang\Object>')
	*/
	public function			createViewSupplier($viewInfo, $callerContext)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFieldJql($fieldName)
	{
		return $fieldName;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			listObjects($results, $composition, $filters, $sorts, $start, $limit)
	{
		$keyDef = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\PKeyDef');
		if (is_null($filters))
			$filters = new \net\dryuf\util\php\StringNativeHashMap();
		$roleQuery = new \net\dryuf\dao\RoleQuery();
		$roleQuery->setColumns("ent");
		$roleQuery->setTable(" FROM ".$this->getJqlName()." ent");
		$roleQuery->setWhere(" WHERE 0=0");
		{
			$ssort = new \net\dryuf\core\StringBuilder();
			if (is_null($sorts) || $sorts->size() == 0) {
				$listOrder = \net\dryuf\core\Dryuf::getClassAnnotation($this->dataClass, 'net\dryuf\meta\ListOrder');
				if (!is_null($listOrder) && count($listOrder->order()) != 0) {
					foreach ($listOrder->order() as $fieldName) {
						$ssort->append(", ent.")->append($fieldName);
					}
				}
				else {
					$ssort->append(", ent.".$this->getPkName());
				}
			}
			else {
				foreach ($sorts as $s) {
					$ssort->append(", ent.")->append($s);
				}
			}
			$roleQuery->appendSort("ORDER BY ".$ssort->substring(1));
		}
		{
			if (!($keyDef->composPath() === "")) {
				$roleQuery->appendWhere(" AND ent.".$keyDef->composPath()." = ?");
				$roleQuery->appendWhereBind($this->composMeta->getEntityPkValue($composition->getEntity()));
			}
		}
		foreach ($filters->entrySet() as $filter) {
			$fkey = $filter->getKey();
			$fvalue = $filter->getValue();
			if (substr($fkey, 0, strlen("-")) == "-") {
				if (($fkey === "-composKey")) {
					throw new \net\dryuf\core\ReportException("-composKey unsupported yet");
				}
				elseif (($fkey === "-cond")) {
					foreach ($fvalue as $cond) {
						$ckey = \net\dryuf\util\MapUtil::getMapMandatory($cond, "field");
						$cvalue = \net\dryuf\util\MapUtil::getMapMandatory($cond, "value");
						$op = \net\dryuf\util\MapUtil::getMapMandatory($cond, "op");
						if (is_null(($jqlName = $this->getFieldJql($ckey))))
							throw new \net\dryuf\core\ReportException("field not found: ".$ckey);
						if (is_null(($jqlOperation = self::$jqlOperatorMap->get($op))))
							throw new \net\dryuf\core\ReportException("operator not found: ".$op);
						$roleQuery->appendWhere(" AND ent.".$jqlName." ".$jqlOperation." ?");
						$roleQuery->appendWhereBind($cvalue);
					}
				}
				elseif (($fkey === "-suggest")) {
					$fvalue = $fvalue."%";
					$suggestDef = \net\dryuf\core\Dryuf::getClassMandatoryAnnotation($this->dataClass, 'net\dryuf\meta\SuggestDef');
					$roleQuery->appendWhere(" AND (0=1");
					foreach ($suggestDef->fields() as $field) {
						$roleQuery->appendWhere(" OR ent.".$this->getFieldJql($field)." LIKE ?");
						$roleQuery->appendWhereBind($fvalue);
					}
					$roleQuery->appendWhere(")");
				}
				else {
					throw new \net\dryuf\core\ReportException("unknown high-level filter: ".$fkey);
				}
			}
			elseif (substr($fkey, 0, strlen(":")) == ":") {
				if (is_null(($filterDef = $this->classMeta->getFilterDefsHash()->get(strval(substr($fkey, 1))))))
					throw new \net\dryuf\core\RuntimeException("unsupported filterDef: ".$fkey);
				$condition = str_replace($fkey, "?", $filterDef->condition());
				$roleQuery->appendWhere(" AND ");
				$roleQuery->appendWhere($condition);
				$roleQuery->appendWhereBind($fvalue);
			}
			elseif (!is_null(($jqlName = $this->getFieldJql($fkey)))) {
				$roleQuery->appendWhere(" AND ent.".$jqlName." = ?");
				$roleQuery->appendWhereBind($fvalue);
			}
			else {
				throw new \net\dryuf\core\ReportException($fkey." not defined as a field");
			}
		}
		$roleProc = $this->createRoleProcessor($composition->getRole());
		$roleProc->modifyQuery($roleQuery);
		$sstatement = "SELECT ".$roleQuery->getColumns()." ".$roleQuery->getTable()." ".$roleQuery->getWhere()." ".$roleQuery->getSort();
		$query = $this->createQuery(new \net\dryuf\core\StringBuilder($sstatement), $roleQuery->getBinds()->toArray());
		if (!is_null($limit)) {
			$query->setFirstResult(intval($start));
			$query->setMaxResults(intval($limit));
		}
		$objects = $query->getResultList();
		$viewSupplier = $this->createViewSupplier(null, $composition->getRole());
		foreach ($objects as $row) {
			$result = $roleProc->createEntityFromResult($row);
			if (!is_null($viewSupplier))
				$viewSupplier->processResult($result);
			$results->add($result);
		}
		if (is_null($limit)) {
			return $objects->size();
		}
		else {
			$countQuery = $this->createQuery((new \net\dryuf\core\StringBuilder("SELECT COUNT(*) "))->append($roleQuery->getTable())->append(" ")->append($roleQuery->getWhere()), $roleQuery->getWhereBinds()->toArray());
			return intval($countQuery->getSingleResult());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			retrieveObject($composition, $pk)
	{
		if (is_null($pk))
			throw new \net\dryuf\core\InvalidValueException($pk, "missing pk");
		$roleQuery = new \net\dryuf\dao\RoleQuery();
		$roleQuery->setColumns("ent");
		$roleQuery->setWhere("WHERE ent.".$this->getPkName()." = ?");
		$roleQuery->setTable(" FROM ".$this->getJqlName()." ent");
		$roleQuery->appendWhereBind($pk);
		$roleProc = $this->createRoleProcessor($composition->getRole());
		$roleProc->modifyQuery($roleQuery);
		$sstatement = "SELECT ".$roleQuery->getColumns()." ".$roleQuery->getTable()." ".$roleQuery->getWhere()." ".$roleQuery->getSort();
		$query = $this->createQuery(new \net\dryuf\core\StringBuilder($sstatement), $roleQuery->getBinds()->toArray());
		$objects = $query->getResultList();
		if ($objects->size() == 0)
			return null;
		return $roleProc->createEntityFromResult($objects->get(0));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			createObject($composition, $values)
	{
		if (!$this->classMeta->canNew($composition->getRole()))
			throw new \net\dryuf\core\SecurityException("Denied to new ".$this->dataClass);
		$object = null;
		try {
			$object = \net\dryuf\core\Dryuf::createClassArg0($this->dataClass);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw \net\dryuf\core\Dryuf::translateException($ex);
		}
		\net\dryuf\validation\ObjectRoleUtil::newWithRole(new \net\dryuf\validation\ObjectValidationErrors($object), $object, $composition->getRole(), $values);
		if ($this->classMeta->hasCompos()) {
			$this->classMeta->setComposKey($object, $this->composMeta->getEntityPkValue($composition->getEntity()));
		}
		$this->entityManager->persist($object);
		$this->entityManager->flush();
		return $object;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			updateObject($holder, $pk, $values)
	{
		$object = $holder->getEntity();
		\net\dryuf\validation\DataValidatorUtil::validateWithSet($holder->getRole(), $object, $values);
		$this->entityManager->merge($object);
		$this->entityManager->flush();
		return $object;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteObject($composition, $pk)
	{
		$holder = $this->retrieveObject($composition, $pk);
		if (is_null($holder))
			return false;
		if (!$this->classMeta->canDel($holder->getRole()))
			throw new \net\dryuf\core\SecurityException("Denied to new ".$this->dataClass);
		$sstatement = "DELETE FROM ".$this->getJqlName()." WHERE ".$this->getPkName()." = ?";
		return $this->createQuery(new \net\dryuf\core\StringBuilder($sstatement), 
			array(
				$pk
			))->executeUpdate() != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getComposPath()
	{
		return $this->composPath;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getJqlName()
	{
		return preg_replace('/.*\\\\/', '', $this->dataClass);
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
	@\net\dryuf\core\Type(type = 'javax\persistence\EntityManager')
	*/
	protected			$entityManager;

	/**
	@\net\dryuf\core\Type(type = 'javax\persistence\EntityManager')
	*/
	public function			getEntityManager()
	{
		return $this->entityManager;
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
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$classMeta;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Field')
	*/
	protected			$pkField;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$composPath;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$composMeta;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	static				$jqlOperatorMap;

	public static function		_initManualStatic()
	{
		self::$jqlOperatorMap = \net\dryuf\util\MapUtil::createStringNativeHashMap("=", "==", "==", "==", "!=", "!=", ">", ">", "<", "<", ">=", ">=", "<=", "<=", "LIKE", "LIKE");
	}

};

\net\dryuf\dao\RoleDaoAccessJpa::_initManualStatic();


?>
