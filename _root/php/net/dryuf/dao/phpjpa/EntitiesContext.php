<?php

#
# Dryuf framework
#
# ----------------------------------------------------------------------------------
#
# Copyright (C) 2000-2015 Zbyněk Vyškovský
#
# ----------------------------------------------------------------------------------
#
# LICENSE:
#
# This file is part of Dryuf
#
# Dryuf is free software; you can redistribute it and/or modify it under the
# terms of the GNU Lesser General Public License as published by the Free
# Software Foundation; either version 3 of the License, or (at your option)
# any later version.
#
# Dryuf is distributed in the hope that it will be useful, but WITHOUT ANY
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
# FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for
# more details.
#
# You should have received a copy of the GNU Lesser General Public License
# along with Dryuf; if not, write to the Free Software Foundation, Inc., 51
# Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#
# @author	2000-2015 Zbyněk Vyškovský
# @link		mailto:kvr@matfyz.cz
# @link		http://kvr.matfyz.cz/software/java/dryuf/
# @link		http://github.com/dryuf/
# @license	http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License v3
#

namespace net\dryuf\dao\phpjpa;


abstract class ContextKey extends \net\dryuf\core\Object
{
	public function			__construct($clazz, $pk)
	{
		$this->clazz = $clazz;
		$this->pk = $pk;
	}

	public				$clazz;

	public				$pk;
}

class ContextKeyScalar extends ContextKey
{
	public function			hashCode()
	{
		return ord(substr($this->clazz, -1))*17+\net\dryuf\core\Dryuf::hashCodeObject($this->pk);
	}

	public function			equals($s)
	{
		return $this->clazz == $s->clazz && $this->pk == $s->pk;
	}
}

class ContextKeyEmbedded extends ContextKey
{
	public function			hashCode()
	{
		return ord(substr($this->clazz, -1))*17+$this->pk->hashCode();
	}

	public function			equals($s)
	{
		return $this->clazz == $s->clazz && $this->pk->equals($s->pk);
	}
}

class EntitiesContext
{
	public function			__construct(\net\dryuf\dao\phpjpa\EntityManagerPhpJpa $entityManager)
	{
		$this->appContainer = $entityManager->getAppContainer();
		$this->dataSource = $entityManager->getDataSource();
		$this->entitiesConfig = $entityManager->getEntitiesConfig();

		$this->entitiesMap = new \net\dryuf\util\HashMap();
		$this->entitiesDup = new \net\dryuf\util\HashMap();
	}

	public function			__destruct()
	{
		if (!is_null($this->connection))
			$this->closeContext(false);
	}

	public function			destroyContext()
	{
		$this->dataSource = null;
		$this->entitiesConfig = null;
		$this->appContainer = null;
	}

	public function			isClosed()
	{
		return $this->dataSource == null;
	}

	public function			createQuery($query)
	{
		if ($this->dataSource == null)
			throw new \RuntimeException("running query on closed context");
		return new QueryPhpJpa($this, $query);
	}

	public function			find($clazz, $pk)
	{
		$meta = JpaMeta::openEntity($this->appContainer, $clazz);
		if (!is_null($obj = $this->getFromContext($meta, $pk)))
			return $obj;
		$result = $this->createQuery("FROM ".$meta->baseName." WHERE ".$meta->pkName." = ?1")->setParameter(1, $pk)->getResultList();
		if ($result->size() == 0)
			return null;
		if ($result->size() > 1)
			throw new \net\dryuf\validation\UniqueValidationException("value not unique for $clazz");
		return $result->get(0);
	}

	public function			persist($obj)
	{
		$meta = JpaMeta::openEntity($this->appContainer, get_class($obj));
		$this->insertEntity($meta, $obj);
		$contextKey = $this->createContextKeyFromEntity($meta, $obj);
		$this->entitiesMap->put($contextKey, $obj);
		$this->entitiesDup->put($contextKey, $obj);
		return $obj;
	}

	public function			flush()
	{
		foreach ($this->entitiesMap->entrySet() as $entry) {
			$key = $entry->getKey();
			$obj = $entry->getValue();
			$dup = $this->entitiesDup->get($key);
			if ($dup == null)
				continue;
			$meta = JpaMeta::openEntity($this->appContainer, get_class($obj));
			if ($this->compareEntity($meta, $obj, $dup))
				continue;
			$this->updateEntity($meta, $obj, $dup);
			$this->entitiesDup->put($key, $this->duplicateEntity($meta, $obj));
		}
	}

	public function			merge($obj)
	{
		$clazz = get_class($obj);
		$meta = JpaMeta::openEntity($this->appContainer, $clazz);
		$pk = $meta->getPkValue($obj);
		$cached = $this->find($clazz, $pk);
		if (is_null($cached))
			return $this->persist($obj);
		$this->copyEntityClass($meta, $cached, $obj);
		return $cached;
	}

	public function			remove($obj)
	{
		$clazz = get_class($obj);
		$meta = JpaMeta::openEntity($this->appContainer, $clazz);
		$pk = $meta->getPkValue($obj);
		$binds = array();
		$pkcond = $this->buildPkCondition($binds, $meta, $pk);
		$sql = "DELETE FROM ".$meta->baseName." WHERE ".substr($pkcond, 5);
		$connection = $this->getConnection();
		$statement = $connection->prepareStatement($sql)->bindParams($binds);
		$statement->executeUpdate();
		$contextKey = $this->createContextKeyFromPk($meta, $pk);
		$this->entitiesMap->remove($contextKey);
		$this->entitiesDup->remove($contextKey);
	}

	public function			createNativeQuery($query, $resultClass = null)
	{
		if ($this->dataSource == null)
			throw new \RuntimeException("running query on closed context");
		return new NativeQueryPhpJpa($this, $query, $resultClass);
	}

	public function			createContextKeyFromEntity($meta, $obj)
	{
		return $this->createContextKeyFromPk($meta, $meta->getPkValue($obj));
	}

	public function			createContextKeyFromPk($meta, $pk)
	{
		$pkMeta = $meta->getPkMeta();
		return $pkMeta->isScalar() ? new ContextKeyScalar($meta->clazz, $pk) : new ContextKeyEmbedded($meta->clazz, $pk);
	}

	public function			getFromContext($meta, $pk)
	{
		return $this->entitiesMap->get($this->createContextKeyFromPk($meta, $pk));
	}

	public function			addToContext($meta, $obj)
	{

		$contextKey = $this->createContextKeyFromEntity($meta, $obj);
		if (!is_null($saved = $this->entitiesMap->get($contextKey)))
			return $saved;
		$this->entitiesMap->put($contextKey, $obj);
		$this->entitiesDup->put($contextKey, $this->duplicateEntity($meta, $obj));
		return $obj;
	}

	public function			readOneToMany(\net\dryuf\dao\phpjpa\JpaMetaField $fieldMeta, $ownerMeta, $ownerPk)
	{
		$m = preg_split('/[.\\\\]/', $fieldMeta->associationClass);
		$shortClazz = array_pop($m);
		$jql = "FROM $shortClazz ent WHERE __ONETOMANYCHILD(ent";
		$jql .= join("", array_map(function ($joinColumn) { return ", ".$joinColumn->referencedColumnName(); }, $fieldMeta->joinColumns));
		$jql .= ") = (SELECT __ONETOMANYPARENT(parent";
		$jql .= join("", array_map(function ($joinColumn) { return ", ".$joinColumn->name(); }, $fieldMeta->joinColumns));
		$jql .= ") FROM $ownerMeta->baseName parent WHERE parent.$ownerMeta->pkName = ?1)";
		if (!is_null($fieldMeta->associationOrderBy)) {
			$jql .= " ORDER BY ";
			$counter = 0;
			foreach ($fieldMeta->associationOrderBy as $item) {
				if ($counter++ > 0)
					$jql .= ", ";
				$jql .= $item;
			}
		}
		return $this->createQuery($jql)->setParameter(1, $ownerPk)->getResultList();
	}

	public function			stringifyKey($pk)
	{
		if (is_object($pk)) {
			$out = "";
			$ref = new ReflectionObject($pk);
			foreach ($ref->getProperties() as $prop) {
				$out .= $this->stringifyKey($this->getObjectField($pk, $prop));
			}
			return $out;
		}
		else {
			return urlencode(strval($pk))."/";
		}
	}

	public function			getObjectField($obj, $prop)
	{
		$prop->setAccessible(true);
		return $prop->getValue($obj);
	}

	public function			setObjectField($obj, $prop, $value)
	{
		$prop->setAccessible(true);
		return $prop->setValue($obj, $value);
	}

	public function			getAppContainer()
	{
		return $this->appContainer;
	}

	public function			getEntitiesConfig()
	{
		return $this->entitiesConfig;
	}

	public function			closeContext($commit)
	{
		$ex = null;
		try {
			$this->flush();
			if (!is_null($connection = $this->connection)) {
				$this->connection = null;
				if ($commit) {
					$connection->commit();
					if ($this->getRollbackOnly()) {
						$connection->rollback();
						throw new \RuntimeException("commit on transaction marked for rollbackOnly");
					}
				}
				else {
					$connection->rollback();
				}
				$connection->close();
			}
		}
		catch (\Exception $ex) {
			$this->destroyContext();
			throw $ex;
		}
		$this->destroyContext();
	}

	public function			getRollbackOnly()
	{
		return $this->rollbackOnly;
	}

	public function			setRollbackOnly()
	{
		$this->rollbackOnly = true;
	}

	public function			getConnection()
	{
		if (is_null($this->connection)) {
			$this->connection = $this->dataSource->getConnection();
			$this->connection->setAutoCommit(false);
		}
		return $this->connection;
	}

	protected function		compareEntity($meta, $obj, $dup)
	{
		return $this->compareEntityClass($meta, $obj, $dup);
	}

	protected function		compareEntityClass($meta, $obj, $dup)
	{
		foreach ($meta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$value = $meta->getFieldValue($obj, $metaField->fieldName);
			$dvalue = $meta->getFieldValue($dup, $metaField->fieldName);
			if (is_null($value) != is_null($dvalue)) {
				return false;
			}
			elseif (is_null($value)) {
				# both null, continue
				continue;
			}
			elseif ($metaField->embeddedMeta) {
				if (!$this->compareEntityClass($metaField->embeddedMeta, $value, $dvalue))
					return false;
			}
			else if ($value != $dvalue) {
				return false;
			}
		}
		return true;
	}

	protected function		duplicateEntity($meta, $obj)
	{
		$dup = $this->buildDuplicate($meta, $obj);
		return $dup;
	}

	protected function		buildDuplicate($meta, $obj)
	{
		$dup = $this->buildDuplicateClass($meta, $obj);
		return $dup;
	}

	protected function		buildDuplicateClass($meta, $obj)
	{
		$clazz = $meta->clazz;
		$dup = new $clazz();
		foreach ($meta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$value = $meta->getFieldValue($obj, $metaField->fieldName);
			if (is_null($value)) {
				# got null, simply copy
			}
			elseif ($metaField->embeddedMeta) {
				$value = $this->buildDuplicateClass($metaField->embeddedMeta, $value);
			}
			else {
				# got value, simply copy
			}
			$meta->setFieldValue($dup, $metaField->fieldName, $value);
		}
		return $dup;
	}

	protected function		copyEntityClass($meta, $obj, $source)
	{
		foreach ($meta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$svalue = $meta->getFieldValue($source, $metaField->fieldName);
			if ($metaField->embeddedMeta && !is_null($svalue)) {
				;
				if (!is_null($nvalue = $meta->getFieldValue($obj, $metaField->fieldName))) {
					$this->copyEntityClass($metaField->embeddedMeta, $nvalue, $svalue);
				}
				else {
					$meta->setFieldValue($obj, $metaField->fieldName, $svalue);
				}
			}
			else {
				$meta->setFieldValue($obj, $metaField->fieldName, $svalue);
			}
		}
	}

	protected function		insertEntity($meta, $obj)
	{
		$generated = null;
		$binds = array();
		$sql = $this->buildInsert($generated, $binds, $meta, $obj);
		$connection = $this->getConnection();
		$statement = $connection->prepareStatement($sql)->bindParams($binds);
		$statement->executeUpdate();
		if (!is_null($generated)) {
			$meta->setFieldValue($obj, $generated->fieldName, $statement->getInsertId());
		}
	}

	protected function		buildInsert(&$generated, &$binds, $meta, $obj)
	{
		$names = "";
		$values = "";
		$this->buildInsertClass($generated, $names, $values, $binds, $meta, $obj);
		return "INSERT INTO $meta->tableName ( ".substr($names, 2)." ) VALUES ( ".substr($values, 2)." )";
	}

	protected function		buildInsertClass(&$generated, &$names, &$values, &$binds, $meta, $obj)
	{
		foreach ($meta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$value = is_null($obj) ? null : $meta->getFieldValue($obj, $metaField->fieldName);
			if ($metaField->embeddedMeta) {
				$this->buildInsertClass($generated, $names, $values, $binds, $metaField->embeddedMeta, $value);
			}
			elseif (!is_null($metaField->generatedStrategy)) {
				if (!is_null($generated))
					throw new \RuntimeException("more than one GeneratedValue");
				$generated = $metaField;
			}
			else {
				$names .= ", ".$metaField->columnName;
				$values .= ", ?";
				array_push($binds, $value);
			}
		}
	}

	protected function		updateEntity($meta, $obj)
	{
		$binds = array();
		$sql = $this->buildUpdate($binds, $meta, $obj);
		$connection = $this->getConnection();
		$statement = $connection->prepareStatement($sql)->bindParams($binds);
		$count = $statement->executeUpdate();
	}

	protected function		buildUpdate(&$binds, $meta, $obj)
	{
		$sets = "";
		$binds = array();
		$this->buildUpdateClass($sets, $binds, $meta, $obj);
		$pkcond = $this->buildPkCondition($binds, $meta, $meta->getPkValue($obj));
		return "UPDATE $meta->tableName SET ".substr($sets, 2)." WHERE ".substr($pkcond, 5);
	}

	protected function		buildUpdateClass(&$sets, &$binds, $meta, $obj)
	{
		foreach ($meta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$value = is_null($obj) ? null : $meta->getFieldValue($obj, $metaField->fieldName);
			if ($metaField->embeddedMeta) {
				$this->buildUpdateClass($sets, $binds, $metaField->embeddedMeta, $value);
			}
			else {
				$sets .= ", ".$metaField->columnName." = ?";
				array_push($binds, $value);
			}
		}
	}

	protected function		buildPkCondition(&$binds, $meta, $pk)
	{
		$pkMeta = $meta->getPkMeta();

		if ($pkMeta->embeddedMeta) {
			return $this->buildConditionClass($binds, $pkMeta->embeddedMeta, $pk);
		}
		else {
			array_push($binds, $pk);
			return " AND ".$pkMeta->columnName." = ?";
		}
	}

	protected function		buildConditionClass(&$binds, $meta, $obj)
	{
		$condition = "";
		if (!isset($meta->fields))
			throw new \RuntimeException("no fields, wrong meta?");
		foreach ($meta->fields as $metaField) {
			$value = is_null($obj) ? null : $meta->getFieldValue($obj, $metaField->fieldName);
			if ($metaField->embeddedMeta) {
				$condition .= $this->buildConditionClass($binds, $metaField->embeddedMeta, $value);
			}
			else {
				$condition .= " AND ".$metaField->columnName." = ?";
				array_push($binds, $value);
			}
		}
		return $condition;
	}

	protected function		mergeEntity($meta, $obj)
	{
		throw new \RuntimeException("TODO");
	}

	protected			$appContainer;

	protected			$entityManager;

	protected			$entitiesConfig;

	protected			$rollbackOnly;

	protected			$connection;

	protected			$entitiesMap;

	protected			$entitiesDup;

	protected			$flushQueue;
};


?>
