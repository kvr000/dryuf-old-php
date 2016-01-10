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


/**
 * Manages the data from visitor action.
 */
class VisitResult
{
	const				RT_None			= 0;
	const				RT_Select		= 1;
	const				RT_Delete		= 2;
	const				RT_Update		= 3;
	const				RT_Insert		= 4;

	const				RT_Source		= 5;
	const				RT_Field		= 6;
	const				RT_Star			= 7;

	public function			__construct($type)
	{
		$this->type = $type;
	}

	/**
	 * Sets the SQL string to passed value.
	 *
	 * @param string $str
	 * 	SQL string to set
	 *
	 * @return this
	 */
	public function			setSqlString($str)
	{
		$this->sqlStrings = array($str);
		return $this;
	}

	/**
	 * Inserts SQL string at the beginning.
	 *
	 * @param string $str
	 * 	SQL string to insert
	 *
	 * @return this
	 */
	public function			insertSqlString($str)
	{
		array_unshift($this->sqlStrings, $str);
		return $this;
	}

	/**
	 * Appends SQL string at the end.
	 *
	 * @param string $str
	 * 	SQL string to append
	 *
	 * @return this
	 */
	public function			appendSqlString($str)
	{
		array_push($this->sqlStrings, $str);
		return $this;
	}

	/**
	 * Injects string after each part, including the last one.
	 *
	 * @param array $injects
	 * 	SQL strings to inject after each part
	 *
	 * @return this
	 */
	public function			injectSqlStrings($injects)
	{
		for ($i = 1; $i <= count($this->sqlStrings); $i += count($injects)+1) {
			array_splice($this->sqlStrings, $i, 0, $injects);
		}
		return $this;
	}

	/**
	 * Removes last part from SQL strings.
	 *
	 * @return this
	 */
	public function			removeLastSqlString()
	{
		array_pop($this->sqlStrings);
		return $this;
	}

	/**
	 * Sets the binding reference to passed value.
	 *
	 * @param string $bindRef
	 * 	BindRef to set
	 *
	 * @return this
	 */
	public function			setBindRef($bindRef)
	{
		$this->bindRefs = array($bindRef);
		return $this;
	}

	/**
	 * Appends binding reference.
	 *
	 * @param string $bindRef
	 * 	BindRef to add
	 *
	 * @return this
	 */
	public function			appendBindRef($bindRef)
	{
		array_push($this->bindRefs, $bindRef);
		return $this;
	}

	/**
	 * Concatenates the current string together.
	 *
	 * @return this
	 */
	public function			unifySql()
	{
		$this->sqlStrings = array($this->getSql());
		return $this;
	}

	/**
	 * Gets current SQL string.
	 *
	 * @return SQL string
	 */
	public function			getSql()
	{
		return join("", $this->sqlStrings);
	}

	/**
	 * Gets current SQL string, joining the parts.
	 *
	 * @param string $joinString
	 * 	string to use to join the parts
	 *
	 * @return SQL string
	 */
	public function			joinSql($joinString)
	{
		return join($joinString, $this->sqlStrings);
	}

	/**
	 * Merges this result with another one, conencting the SQLs with joinString.
	 *
	 * @param string $connectString
	 * 	string to use to join the results
	 * @param VisitResult $another
	 * 	result to append
	 *
	 * @return this
	 */
	public function			merge($connectString, $another)
	{
		if (count($this->sqlStrings) == 0) {
			$this->sqlStrings = $another->sqlStrings;
		}
		elseif (count($another->sqlStrings) != 0) {
			array_push($this->sqlStrings, $connectString);
			$this->sqlStrings = array_merge($this->sqlStrings, $another->sqlStrings);
		}
		if (count($this->bindRefs) == 0)
			$this->bindRefs = $another->bindRefs;
		elseif (count($another->bindRefs) != 0)
			$this->bindRefs = array_merge($this->bindRefs, $another->bindRefs);
		$this->objectArity += $another->objectArity;
		$this->sqlArity += $another->sqlArity;
		return $this;
	}

	/**
	 * Merges this result with another one, combining with additional set of SQL strings.
	 *
	 * @param string $connectString
	 * 	string to use to join the results
	 * @param string $combineString
	 * 	string to connect result another with moreSql set
	 * @param VisitResult $another
	 * 	result to append
	 * @param array $moreSql
	 * 	strings to append after each SQL string in another
	 *
	 * @return this
	 */
	public function			mergeCombined($connectString, $combineString, $another, $moreSql)
	{
		if (count($another->sqlStrings) != count($moreSql)) {
			var_dump($this);
			var_dump($another);
			var_dump($moreSql);
			throw new \RuntimeException("mergeCombined: another=".count($another->sqlStrings)." != moreSql=".count($moreSql));
		}
		for ($i = 0; $i < count($moreSql); $i++) {
			if ($i != 0)
				$this->appendSqlString($connectString);
			array_push($this->sqlStrings, $another->sqlStrings[$i], $combineString, $moreSql[$i]);
		}
		if (count($this->bindRefs) == 0)
			$this->bindRefs = $another->bindRefs;
		elseif (count($another->bindRefs) != 0)
			$this->bindRefs = array_merge($this->bindRefs, $another->bindRefs);
		$this->objectArity += $another->objectArity;
		$this->sqlArity += $another->sqlArity;
		return $this;
	}

	/**
	 * Appends result.
	 *
	 * @param VisitResult $another
	 * 	result to append
	 *
	 * @return this
	 */
	public function			append($another)
	{
		return $this->merge("", $another);
	}

	/** Result type - RT. */
	public				$type;

	/** List of SQL strings to represent this part. */
	public				$sqlStrings = array();

	/** List of bind references (ints or strings). */
	public				$bindRefs = array();

	/** Source definition object. */
	public				$sourceDef;

	/** Field definition object. */
	public				$columnDef;

	/** BindRef definition in case this result refers to placement. */
	public				$bindRef;

	/** Object arity of this result. */
	public				$objectArity = 1;

	/** SQL arity of this result. */
	public				$sqlArity = 1;
}


/**
 * BindRef represents the single binding reference, i.e. the single placement within SQL string.
 */
class BindRef
{
	public function			__construct($id, $sqlArity)
	{
		$this->id = $id;
		$this->sqlArity = $sqlArity;
	}

	/** Id (name or int) of this bind. */
	public				$id;

	/** SQL arity of this bind. */
	public				$sqlArity;
}


/**
 * Information about source definition.
 */
class SourceDef
{
	const				ST_Entity			= 1;
	const				ST_Select			= 2;

	function			__construct($sourceType)
	{
		$this->sourceType = $sourceType;
	}

	function			getSqlAlias()
	{
		++$this->sqlAliasUsed;
		return $this->sqlAlias;
	}

	/** Type of source - ST. */
	public				$sourceType;

	/** Alias of this source, null if nothing. */
	public				$alias;

	/** SQL Alias of this source. */
	public				$sqlAlias;

	/** Counter how many times was alias referenced. */
	public				$sqlAliasUsed = 0;

	/** Field definition of entity (in case of entity). */
	public				$columnDef;

	/** Fields list of this source (in case of subselect source). */
	public				$fields;
};


/**
 * Information about single field in select-list.
 */
class ColumnDef
{
	/** Name of field. */
	public				$name;

	/** JpaMeta information about this field. */
	public				$jpaMeta;

	/** Data type in case of primitive type. */
	public				$primitiveType;

	/** Alias of this field. */
	public				$alias;

	/** SQL Aliases of the field elements. */
	public				$sqlFieldsAliases;
};


/**
 * Information about identifier within current context.
 */
class IdentifierInfo
{
	const				II_None				= 0;		///< none
	const				II_Entity			= 1;		///< entity source
	const				II_SubSelect			= 2;		///< sub select source
	const				II_Member			= 3;		///< entity member
	const				II_Field			= 4;		///< select field

	public function			__construct($identifierType)
	{
		$this->identifierType = $identifierType;
	}

	/** Type of this result (II_*). */
	public				$identifierType;

	/** Owning source. */
	public				$ownerSourceDef;

	/** Field definition (in case of sub select). */
	public				$columnDef;

	/** Field meta (in case of class field). */
	public				$metaField;
};


/**
 * SQL build context, contains information about all variables within single subselect.
 */
class SqlBuilderContext
{
	public function			__construct($parent)
	{
		$this->parent = $parent;
	}

	public function			getParent()
	{
		return $this->parent;
	}

	public function			getRoot()
	{
		if (is_null($this->parent)) {
			return $this;
		}
		elseif (!is_null($this->root)) {
			return $this->root;
		}
		else {
			for ($root = $this->parent; $root->parent; $root = $root->parent) ;
			$this->root = $root;
			return $root;
		}
	}

	public function			allocateCounter()
	{
		if ($this->parent)
			return $this->parent->allocateCounter();
		return ++$this->uniqueCounter;
	}

	public function			createSqlAlias($suggested)
	{
		$sqlAliases = &$this->getRoot()->sqlAliases;
		if (!$suggested)
			$suggested = "z";
		$sqlAlias = $suggested;
		while (isset($sqlAliases[$sqlAlias]) || isset(self::$sqlKeywords[$sqlAlias])) {
			$sqlAlias = $suggested.$this->allocateCounter();
		}
		$sqlAliases[$sqlAlias] = 1;
		return $sqlAlias;
	}

	public function			registerSource($sourceDef)
	{
		array_push($this->sources, $sourceDef);
		if ($sourceDef->alias)
			$this->sourcesHash[$sourceDef->alias] = $sourceDef;
		return $sourceDef->sqlAlias = $this->createSqlAlias($sourceDef->alias ? $sourceDef->alias : "t");
	}

	public function			checkSource($name)
	{
		return isset($this->sourcesHash[$name]) ? $this->sourcesHash[$name] : (!is_null($this->parent) ? $this->parent->checkSource($name) : null);
	}

	public function			buildIdentifiers()
	{
		if (!$this->identifiers) {
			$this->identifiers = array();
			foreach ($this->sources as $sourceDef) {
				if ($sourceDef->sourceType == SourceDef::ST_Entity) {
					$identifierResult = new IdentifierInfo(IdentifierInfo::II_Entity);
					$identifierResult->ownerSourceDef = $sourceDef;
					$this->identifiers[$sourceDef->alias] = $identifierResult;
					foreach ($sourceDef->columnDef->jpaMeta->fields as $metaField) {
						if (array_key_exists($metaField->fieldName, $this->identifiers)) {
							$this->identifiers[$metaField->fieldName] = null;
						}
						else {
							$identifierResult = new IdentifierInfo(IdentifierInfo::II_Member);
							$identifierResult->ownerSourceDef = $sourceDef;
							$identifierResult->metaField = $metaField;
							$this->identifiers[$metaField->fieldName] = $identifierResult;
						}
					}
				}
				else {
					assert($sourceDef->sourceType == SourceDef::ST_Select);
					$identifierResult = new IdentifierInfo(IdentifierInfo::II_SubSelect);
					$identifierResult->ownerSourceDef = $sourceDef;
					$this->identifiers[$sourceDef->alias] = $sourceDef;
					foreach ($sourceDef->fields as $columnDef) {
						if (array_key_exists($columnDef->alias, $this->identifiers)) {
							$this->identifiers[$columnDef->alias] = null;
						}
						else {
							$identifierResult = new IdentifierInfo(IdentifierInfo::II_Field);
							$identifierResult->ownerSourceDef = $sourceDef;
							$identifierResult->columnDef = $columnDef;
							$this->identifiers[$columnDef->alias] = $identifierResult;
						}
					}
				}
			}
		}
	}

	public function			checkFieldIdentifier($name)
	{
		if (!$this->identifiers)
			$this->buildIdentifiers();
		if (array_key_exists($name, $this->identifiers)) {
			if (is_null($this->identifiers[$name]))
				throw new \RuntimeException("ambigious name: $name");
			return $this->identifiers[$name];
		}
		if ($this->parent)
			return $this->parent->checkFieldIdentifier($name);
		return null;
	}

	protected			$parent;
	protected			$root;

	public				$sources = array();
	public				$identifiers;

	public				$sourcesHash;
	public				$sqlAliases;

	public				$uniqueCounter = 0;

	public static			$sqlKeywords = array(
		"SELECT"			=> 1,
		"DELETE"			=> 1,
		"UPDATE"			=> 1,
		"FROM"				=> 2,
		"WHERE"				=> 2,
		"HAVING"			=> 2,
		"GROUP"				=> 2,
		"ORDER"				=> 2,
		"BY"				=> 2,
		"CASE"				=> 2,
		"WHEN"				=> 2,
		"THEN"				=> 2,
		"END"				=> 2,
		"NOT"				=> 3,
		"EXIST"				=> 3,
		"IN"				=> 4,
		"AND"				=> 4,
		"OR"				=> 4,
		"COUNT"				=> 5,
		"SUM"				=> 5,
		"AVG"				=> 5,
		"MAX"				=> 5,
		"MIN"				=> 5,
	);
}


class SqlBuilder
{
	public function			__construct($entitiesConfig)
	{
		$this->entitiesConfig = $entitiesConfig;
		$this->appContainer = $entitiesConfig->getAppContainer();
		$this->dialect = $entitiesConfig->getDialect();
		$this->pushContext();
	}

	public function			pushContext()
	{
		$this->context = new SqlBuilderContext($this->context);
	}

	public function			popContext()
	{
		$this->context = $this->context->getParent();
	}

	public function			visitSelect($selectTree)
	{
		$context = $this->context;
		$result = new VisitResult(VisitResult::RT_Select);
		$result->setSqlString("SELECT");
		$sourceDef = new SourceDef(SourceDef::ST_Select);
		$result->sourceDef = $sourceDef;
		$result->objectArity = 0;
		$result->sqlArity = 0;
		$froms = null;
		$lastSubResult = null;
		foreach ($selectTree->getFroms() as $sourceTree) {
			$lastSubResult = $sourceTree->visit($this);
			$subSourceDef = $lastSubResult->sourceDef;
			$froms ? $froms->merge(", ", $lastSubResult) : ($froms = $lastSubResult);
		}
		$counter = 0;
		$sourceDef->fields = array();
		if (is_null($selectTree->getItems())) {
			// short FROM-only version, get the (only) source and use as a result
			if (count($selectTree->getFroms()) != 1)
				throw new \RuntimeException("expected single source in without-select FROM syntax");
			$fieldResult = new VisitResult(VisitResult::RT_Field);
			$lastSourceDef = $lastSubResult->sourceDef;
			$columnDef = new ColumnDef();
			$fieldResult->columnDef = $columnDef;
			$columnDef->jpaMeta = $lastSourceDef->columnDef->jpaMeta;
			$this->formatEntityColumns($fieldResult, $lastSourceDef->getSqlAlias(), $columnDef);
			array_push($sourceDef->fields, $columnDef);
			$this->prepareFieldSqlAliases($columnDef);
			if ($result->sqlArity == 0)
				$result->sqlArity = 1;
			$result->appendSqlString($counter++ ? ", " : " ");
			$result->mergeCombined(", ", " ", $fieldResult, $columnDef->sqlFieldsAliases);
		}
		else {
			// full SELECT version
			foreach ($selectTree->getItems() as $itemTree) {
				$fieldResult = $itemTree->visit($this);
				$columnDef = $fieldResult->columnDef;
				array_push($sourceDef->fields, $columnDef);
				$this->prepareFieldSqlAliases($columnDef);
				$result->appendSqlString($counter++ ? ", " : " ");
				$result->mergeCombined(", ", " ", $fieldResult, $columnDef->sqlFieldsAliases);
			}
		}
		$result->merge(" FROM ", $froms);
		if ($selectTree->getWhere()) {
			$result->merge(" WHERE ", $selectTree->getWhere()->visit($this));
		}
		if ($selectTree->getGroupBys()) {
			$this->appendGroupBys($result, $selectTree->getGroupBys());
		}
		if ($selectTree->getHaving()) {
			$result->merge(" HAVING ", $selectTree->getHaving()->visit($this));
		}
		if ($selectTree->getOrderBys()) {
			$this->appendOrderBys($result, $selectTree->getOrderBys());
		}
		return $result;
	}

	protected function		appendOrderBys($result, $orderBys)
	{
		$result->appendSqlString(" ORDER BY ");
		foreach ($orderBys as $orderBy) {
			$result->merge("", $orderBy->visit($this));
		}
		return $result->removeLastSqlString();
	}

	protected function		appendGroupBys($result, $groupBys)
	{
		$result->appendSqlString(" GROUP BY ");
		foreach ($groupBys as $groupBy) {
			$result->merge("", $groupBy->visit($this));
			$result->appendSqlString(", ");
		}
		return $result->removeLastSqlString();
	}

	public function			visitDelete($deleteTree)
	{
		$context = $this->context;
		$result = new VisitResult(VisitResult::RT_Delete);
		$result->setSqlString("DELETE");
		$result->objectArity = 0;
		$result->sqlArity = 0;

		$froms = null;
		if (count($deleteTree->getFroms()) != 1)
			throw new \RuntimeException("expected single source in DELETE");
		$froms = $deleteTree->getFroms()->visit($this);
		if (($needAlias = $this->dialect->needDeleteAliasFrom()) != 0) {
			if ($needAlias < 0) {
				if ($froms->sourceDef->sqlAliasUsed)
					throw new \net\dryuf\core\RuntimeException("Driver does not support DELETE alias and this is required by statement");
			}
			else {
				$result->appendSqlString(" ")->appendSqlString($froms->sourceDef->getSqlAlias());
			}
		}
		$result->merge(" FROM ", $froms);

		if ($deleteTree->getWhere())
			$result->merge(" WHERE ", $deleteTree->getWhere()->visit($this));
		if ($deleteTree->getOrderBys()) {
			$this->appendOrderBys($result, $deleteTree->getOrderBys());
		}
		return $result;
	}

	public function			visitUpdate($updateTree)
	{
		$context = $this->context;
		$result = new VisitResult(VisitResult::RT_Update);
		$result->setSqlString("UPDATE");
		$result->objectArity = 0;
		$result->sqlArity = 0;

		$froms = null;
		if (count($updateTree->getFroms()) != 1)
			throw new \RuntimeException("expected single source in UPDATE");
		$froms = $updateTree->getFroms()->visit($this);
		$result->merge(" ", $froms);

		$sets = null;
		foreach ($updateTree->getSets() as $setTree) {
			$setResult = $setTree->visit($this);
			$sets ? $sets->merge(", ", $setResult) : ($sets = $setResult);
		}
		$result->merge(" SET ", $sets);

		if ($updateTree->getWhere())
			$result->merge(" WHERE ", $updateTree->getWhere()->visit($this));
		if ($updateTree->getOrderBys())
			$this->appendOrderBys($result, $updateTree->getOrderBys());
		return $result;
	}

	public function			visitEntitySource($sourceTree)
	{
		$result = new VisitResult(VisitResult::RT_Source);
		$context = $this->context;
		$jpaMeta = \net\dryuf\dao\phpjpa\JpaMeta::openEntity($this->appContainer, $this->entitiesConfig->resolveClassName($sourceTree->getTable()));
		$sourceDef = new SourceDef(SourceDef::ST_Entity);
		$result->sourceDef = $sourceDef;
		$columnDef = new ColumnDef();
		$sourceDef->columnDef = $columnDef;
		$sourceDef->type = SourceDef::ST_Entity;
		$sourceDef->alias = $sourceTree->getAlias();
		$context->registerSource($sourceDef);

		$columnDef->jpaMeta = $jpaMeta;
		$columnDef->alias = $sourceDef->alias;
		$columnDef->sqlAlias = $sourceDef->sqlAlias;
		$result->setSqlString($jpaMeta->tableName." ".$sourceDef->getSqlAlias());

		return $result;
	}

	public function			visitSubSource($subSourceTree)
	{
		throw new \RuntimeException("TODO");
	}

	public function			visitSelectField($selectItemTree)
	{
		$result = $selectItemTree->expression->visit($this);
		if (is_null($columnDef = $result->columnDef))
			$result->columnDef = $columnDef = new ColumnDef();
		$columnDef->alias = $selectItemTree->alias;
		return $result;
	}

	public function			visitIdentifier($identifierTree)
	{
		$context = $this->context;
		$result = new VisitResult(VisitResult::RT_Field);
		$name = $identifierTree->getName();
		$result->name = $name;

		if (!is_null($sourceDef = $context->checkSource($name))) {
			if ($sourceDef->type == SourceDef::ST_Entity) {
				$columnDef = new ColumnDef();
				$result->columnDef = $columnDef;
				$columnDef->name = $name;
				$columnDef->jpaMeta = $sourceDef->columnDef->jpaMeta;
				$result->sqlArity = 0;
				$this->formatEntityColumns($result, $sourceDef->getSqlAlias(), $columnDef);
			}
			else {
				throw new \RuntimeException("field for unexpected source type: ".$name);
			}
		}
		else {
			$identifierResult = $context->checkFieldIdentifier($name);
			if (is_null($identifierResult))
				throw new \RuntimeException("invalid identifier: $name");
			switch ($identifierResult->identifierType) {
			case IdentifierInfo::II_Member:
				$result->sqlArity = 0;
				$this->formatClassField($result, $identifierResult->ownerSourceDef->getSqlAlias(), $identifierResult->ownerSourceDef->columnDef, $identifierResult->ownerSourceDef->columnDef->jpaMeta->getFieldMeta($name));
				break;

			default:
				throw new \RuntimeException("field for unexpected source type $identifierResult->identifierType: ".$name);
			}
		}
		return $result;
	}

	public function			visitOrderByItem($orderByItemTree)
	{
		$result = $orderByItemTree->getExpression()->visit($this);
		if (!is_null($orderByItemTree->direction))
			$result->injectSqlStrings(array(" ".$orderByItemTree->direction, ", "));
		else
			$result->injectSqlStrings(array(", "));
		return $result;
	}

	public function			formatEntityColumns($result, $sourceSqlAlias, $columnDef)
	{
		$this->formatClassColumns($result, $sourceSqlAlias, $columnDef, $columnDef->jpaMeta);
	}

	public function			formatClassField($result, $sourceSqlAlias, $columnDef, $metaField)
	{
		if ($metaField->embeddedMeta) {
			$this->formatClassColumns($result, $sourceSqlAlias, $columnDef, $metaField->embeddedMeta);
		}
		else {
			++$result->sqlArity;
			$result->appendSqlString(!is_null($sourceSqlAlias) ? $sourceSqlAlias.".".$metaField->columnName : $metaField->columnName);
		}
	}

	public function			formatClassColumns($result, $sourceSqlAlias, $columnDef, $jpaMeta)
	{
		foreach ($jpaMeta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$this->formatClassField($result, $sourceSqlAlias, $columnDef, $metaField);
		}
	}

	public function			formatClassPlacementColumns($result, $jpaMeta)
	{
		foreach ($jpaMeta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			if ($metaField->embeddedMeta) {
				$this->formatClassPlacementColumns($result, $metaField->embeddedMeta);
			}
			else {
				++$result->sqlArity;
				$result->appendSqlString("?");
			}
		}
	}

	public function			prepareFieldSqlAliases($columnDef)
	{
		$columnDef->sqlFieldsAliases = array();
		if ($columnDef->jpaMeta) {
			$this->prepareClassSqlAliases($columnDef, $columnDef->jpaMeta);
		}
		else {
			array_push($columnDef->sqlFieldsAliases, $this->context->createSqlAlias($columnDef->alias));
		}
	}

	public function			prepareClassSqlAliases($columnDef, $jpaMeta)
	{
		$context = $this->context;
		foreach ($jpaMeta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			if ($metaField->embeddedMeta) {
				$this->prepareClassSqlAliases($columnDef, $metaField->embeddedMeta);
			}
			else {
				array_push($columnDef->sqlFieldsAliases, $context->createSqlAlias($metaField->columnName));
			}
		}
	}

	public function			visitNull($nullTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$result->setSqlString($nullTree->content);
		return $result;
	}

	public function			visitNumber($numberTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$result->setSqlString($numberTree->content);
		$result->columnDef = new ColumnDef();
		$result->columnDef->primitiveType = preg_match('/^[-+]?\d+$/', $numberTree->content) ? 'int' : 'double';
		return $result;
	}

	public function			visitString($stringTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$result->setSqlString("'".str_replace("'", "\\'", $this->internalString($stringTree->content))."'");
		return $result;
	}

	public function			visitGenericPlacement($position)
	{
		if (!array_key_exists($position, $this->bindsClasses))
			throw new \RuntimeException("unknown bind: $position");
		$clazz = $this->bindsClasses[$position];
		$result = new VisitResult(VisitResult::RT_Field);

		if (is_null($clazz) || $clazz == "")
			$clazz = "void";
		switch ($clazz) {
		case 'void':
		case 'boolean':
		case 'short':
		case 'int':
		case 'integer':
		case 'long':
		case 'float':
		case 'double':
		case 'string':
			$result->sqlArity = 1;
			$result->setSqlString("?");
			$result->columnDef = new ColumnDef();
			$result->columnDef->primitiveType = $clazz;
			break;

		default:
			$sqlBinds = array();
			$result->sqlArity = 0;
			$jpaMeta = JpaMeta::openEmbedded($this->appContainer, $clazz, null, null);
			$result->appendSqlString("( ");
			$this->buildBindsClass($result, $jpaMeta);
			$result->appendSqlString(" )");
			$result->columnDef = new ColumnDef();
			$result->columnDef->jpaMeta = $jpaMeta;
		}

		$result->bindRef = new BindRef($position, 1);
		$result->bindRef->sqlArity = $result->sqlArity;
		$result->appendBindRef($result->bindRef);
		return $result;
	}

	public function			buildBindsClass($result, $jpaMeta)
	{
		foreach ($jpaMeta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			if ($metaField->embeddedMeta) {
				$this->buildBindsClass($result, $metaField->embeddedMeta);
			}
			else {
				if ($result->sqlArity++ > 0)
					$result->appendSqlString(", ");
				$result->appendSqlString("?");
			}
		}
	}

	public function			visitNumberedPlacement($numberedPlacementTree)
	{
		return $this->visitGenericPlacement(strval($numberedPlacementTree->position));
	}

	public function			visitNamedPlacement($namedPlacementTree)
	{
		return $this->visitGenericPlacement($namedPlacementTree->position);
	}

	/**
	 * Resolves the path according to path tree.
	 *
	 * @return
	 * 	IdentifierInfo for the path
	 */
	protected function		resolvePath($pathTree)
	{
		$context = $this->context;
		if ($pathTree instanceof \net\dryuf\dao\phpjpa\parser\IdentifierTree) {
			if (is_null($identifier = $context->checkFieldIdentifier($pathTree->name)))
				throw new \RuntimeException("unknown variable $pathTree->name");
			switch ($identifier->identifierType) {
			case IdentifierInfo::II_Entity:
				return $identifier;

			case IdentifierInfo::II_Member:
				return $identifier;

			default:
				throw new \RuntimeException("TODO");
			}
		}
		elseif ($pathTree instanceof \net\dryuf\dao\phpjpa\parser\MemberTree) {
			$left = $this->resolvePath($pathTree->path);
			$identifier = new IdentifierInfo(IdentifierInfo::II_Member);
			$identifier->ownerSourceDef = $left->ownerSourceDef;
			switch ($left->identifierType) {
			case IdentifierInfo::II_Entity:
				$identifier->metaField = $left->ownerSourceDef->columnDef->jpaMeta->getFieldMeta($pathTree->member);
				break;

			case IdentifierInfo::II_Member:
				if (!$left->metaField->embeddedMeta)
					throw new \RuntimeException("accessing member $pathTree->member on something which is not embedded class");
				$identifier->metaField = $left->metaField->embeddedMeta->getFieldMeta($pathTree->member);
				break;

			default:
				throw new \RuntimeException("TODO");
			}
			return $identifier;
		}
		else {
			throw new \RuntimeException("unsupported path of identifier: ".get_class($path));
		}
	}

	public function			visitMember($memberTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$context = $this->context;
		$path = $memberTree->path;
		$identifier = $this->resolvePath($memberTree);
		switch ($identifier->identifierType) {
		case IdentifierInfo::II_Entity:
			$this->formatClassField($result, $identifier->ownerSourceDef->getSqlAlias(), $identifier->ownerSourceDef->columnDef, $identifier->ownerSourceDef->columnDef->jpaMeta->getFieldMeta($memberTree->member));
			$result->columnDef = $identifier->ownerSourceDef->columnDef;
			break;

		case IdentifierInfo::II_Member:
			$result->sqlArity = 0;
			$this->formatClassField($result, $identifier->ownerSourceDef->getSqlAlias(), null, $identifier->metaField);
			$result->columnDef = $columnDef = new ColumnDef();
			if (!is_null($identifier->metaField->embeddedMeta)) {
				$columnDef->jpaMeta = $identifier->metaField->embeddedMeta;
			}
			else {
				$columnDef->primitiveType = $identifier->metaField->type;
			}
			break;

		default:
			throw new \RuntimeException("TODO");
		}
		return $result;
	}

	public function			visitParenthesized($parenthesizedTree)
	{
		$expressionTree = $parenthesizedTree->getExpression();
		if ($expressionTree instanceof \net\dryuf\dao\phpjpa\parser\SelectTree) {
			$this->pushContext();
		}
		$result = $expressionTree->visit($this);
		if ($expressionTree instanceof \net\dryuf\dao\phpjpa\parser\SelectTree) {
			$this->popContext();
		}
		$result->appendSqlString(")");
		$result->insertSqlString("(");
		$result->unifySql();
		return $result;
	}

	public function			appendTuple($result, $tupleTree)
	{
		foreach ($tupleTree->getExpressions() as $expressionTree) {
			$result->merge(", ", $expressionTree->visit($this));
		}
		return $result;
	}

	public function			visitTuple($tupleTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$this->appendTuple($result, $tupleTree);
		return $result;
 	}
 
	public function			visitUnaryOperation($unaryOperationTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$operand = $unaryOperationTree->getOperand()->visit($this);
		$result->setSqlString($unaryOperationTree->getOperation())->appendSqlString(" ");
		$result->append($operand);
		return $result;
	}

	public function			visitFinalOperand($expressionTree)
	{
		$result = $expressionTree->visit($this);
		if ($result->sqlArity > 1) {
			if ($expressionTree instanceof \net\dryuf\dao\phpjpa\parser\IdentifierTree || $expressionTree instanceof \net\dryuf\dao\phpjpa\parser\MemberTree) {
				$result->setSqlString($result->joinSql(", "));
			}
			$result->insertSqlString("( ");
			$result->appendSqlString(" )");
		}
		return $result;
	}

	public function			specialEqualsOperation($binaryOperationTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$leftTree = $binaryOperationTree->getOperands()[0];
		$rightTree = $binaryOperationTree->getOperands()[1];
		$left = $this->visitFinalOperand($leftTree);
		$right = $this->visitFinalOperand($rightTree);
		$result->append($left);
		$result->appendSqlString(" ")->appendSqlString($binaryOperationTree->getOperation())->appendSqlString(" ");
		$result->append($right);
		return $result;
	}

	public function			specialNotEqualsOperation($binaryOperationTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$left = $this->visitFinalOperand($binaryOperationTree->getOperands()[0]);
		$right = $this->visitFinalOperand($binaryOperationTree->getOperands()[1]);
		$result->append($left);
		$result->appendSqlString(" ")->appendSqlString($binaryOperationTree->getOperation())->appendSqlString(" ");
		$result->append($right);
		return $result;
	}

	public function			visitBinaryOperation($binaryOperationTree)
	{
		$result = null;
		switch ($binaryOperationTree->getOperation()) {
		case "=":
		case "==":
			$result = $this->specialEqualsOperation($binaryOperationTree);
			break;

		case "!=":
			$result = $this->specialNotEqualsOperation($binaryOperationTree);
			break;

		default:
			break;
		}
		if (is_null($result)) {
			$result = new VisitResult(VisitResult::RT_Field);
			$left = $binaryOperationTree->getOperands()[0]->visit($this);
			$right = $binaryOperationTree->getOperands()[1]->visit($this);
			$result->append($left);
			$result->appendSqlString(" ")->appendSqlString($binaryOperationTree->getOperation())->appendSqlString(" ");
			$result->append($right);
		}
		return $result;
	}

	public function			visitCaseOperation($caseTree)
	{
		$result = new VisitResult(VisitResult::RT_Field);
		$result->appendSqlString("CASE");
		foreach ($caseTree->getWhenTrees() as $whenTree) {
			$result->appendSqlString(" WHEN ");
			$result->append($whenTree->getConditionTree()->visit($this));
			$result->appendSqlString(" THEN ");
			$result->append($whenTree->getValueTree()->visit($this));
		}
		$result->appendSqlString(" ELSE ");
		$result->append($caseTree->getElseTree()->visit($this));
		$result->appendSqlString(" END");
		return $result->unifySql();
	}

	public function			visitCall($callTree)
	{
		$pathTree = $callTree->path;
		if ($pathTree instanceof \net\dryuf\dao\phpjpa\parser\MemberTree) {
			throw new \RuntimeException("Calling method $callTree->member on member not supported");
		}
		elseif ($pathTree instanceof \net\dryuf\dao\phpjpa\parser\IdentifierTree) {
			$methodName = $pathTree->name;
		}
		else {
			throw new \RuntimeException("Unsupported call on ".get_class($pathTree->path));
		}

		$args = $callTree->args;

		switch ($methodName) {
		case 'MIN':
		case 'MAX':
		case 'SUM':
		case 'AVG':
		case 'COUNT':
		case 'COALESCE':
			$result = new VisitResult(VisitResult::RT_Field);
			$result->appendSqlString($methodName)->appendSqlString("(");
			$argsResults = array();
			for ($i = 0; $i < count($args); $i++) {
				if ($i != 0)
					$result->appendSqlString(", ");
				array_push($argsResults, $args[$i]->visit($this));
				$result->append($argsResults[$i]);
			}
			$result->appendSqlString(")")->unifySql();
			switch ($methodName) {
			case 'MIN':
			case 'MAX':
			case 'SUM':
			case 'AVG':
			case 'COALESCE':
				for ($i = count($argsResults); --$i >= 0; ) {
					if ($argsResults[$i]->columnDef && $argsResults[$i]->columnDef->primitiveType)
						$result->columnDef = $argsResults[$i]->columnDef;
				}
				break;

			case 'COUNT':
				$result->columnDef = new ColumnDef();
				$result->columnDef->primitiveType = 'long';
				break;
			}
			break;

		case '__ONETOMANYPARENT':
			$result = new VisitResult(VisitResult::RT_Field);
			$parentIdentifier = $this->getTreeIdentifier(array_shift($args));
			$parentSql = $this->getSqlAliasFromSourceIdentifier($parentIdentifier);
			$counter = 0;
			foreach ($args as $joinColumnName) {
				if ($counter++ != 0)
					$result->appendSqlString(", ");
				$result->appendSqlString("$parentSql.".$this->getTreeIdentifier($joinColumnName));
			}
			$result->unifySql();
			break;

		case '__ONETOMANYCHILD':
			$result = new VisitResult(VisitResult::RT_Field);
			$parentIdentifier = $this->getTreeIdentifier(array_shift($args));
			$parentSql = $this->getSqlAliasFromSourceIdentifier($parentIdentifier);
			$counter = 0;
			foreach ($args as $joinColumnName) {
				if ($counter++ != 0)
					$result->appendSqlString(", ");
				$result->appendSqlString("$parentSql.".$this->getTreeIdentifier($joinColumnName));
			}
			$result->insertSqlString("( ");
			$result->unifySql();
			$result->appendSqlString(" )");
			break;

		default:
			// for unknown function just pass to SQL
			$result = new VisitResult(VisitResult::RT_Field);
			$result->appendSqlString($methodName)->appendSqlString("(");
			$argsResults = array();
			for ($i = 0; $i < count($args); $i++) {
				if ($i != 0)
					$result->appendSqlString(", ");
				array_push($argsResults, $args[$i]->visit($this));
				$result->append($argsResults[$i]);
			}
			$result->appendSqlString(")")->unifySql();
		}
		return $result;
	}

	public function			visitStar($starTree)
	{
		$result = new VisitResult(VisitResult::RT_Star);
		$result->setSqlString("*");
		return $result;
	}

	public function			getTreeIdentifier($identifierTree)
	{
		if (!($identifierTree instanceof \net\dryuf\dao\phpjpa\parser\IdentifierTree))
			throw new \RuntimeException("expected IdentifierTree, got ".get_class($identifierTree));
		return $identifierTree->name;
	}

	public function			getSqlAliasFromSourceIdentifier($sourceIdentifier)
	{
		$context = $this->context;

		if (!is_null($sourceDef = $context->checkSource($sourceIdentifier))) {
			if ($sourceDef->type == SourceDef::ST_Entity) {
				return $sourceDef->getSqlAlias();
			}
			else {
				throw new \RuntimeException("expected source identifier, got $sourceIdentifier");
			}
		}
		else {
			throw new \RuntimeException("expected source identifier, got $sourceIdentifier");
		}
	}

	public function			internalString($str)
	{
		if (substr($str, 0, 1) == "'") {
			$str = substr($str, 1, strlen($str)-2);
		}
		elseif (substr($str, 0, 1) == "\"") {
			$str = substr($str, 1, strlen($str)-2);
		}
		$str = preg_replace("/\\\\(.)/", "\$1", $str);
		return $str;
	}

	public				$dialect;

	public				$appContainer;
	public				$entitiesConfig;

	public				$bindsClasses;

	public				$context;
}


class QueryPhpJpa implements \javax\persistence\Query
{
	public function			__construct(\net\dryuf\dao\phpjpa\EntitiesContext $entitiesContext, $jql)
	{
		$this->entitiesContext		= $entitiesContext;
		$this->entitiesConfig		= $entitiesContext->getEntitiesConfig();
		$this->appContainer		= $entitiesContext->getAppContainer();
		$this->dialect			= $this->entitiesConfig->getDialect();
		$this->cacheIdentifier		= $this->entitiesConfig->getCacheIdentifier();
		$this->jql			= $jql;
		$this->binds = array();
	}

	public function			setParameter($position, $value)
	{
		$this->binds[strval($position)] = $value;
		return $this;
	}

	public function			setFirstResult($firstResult)
	{
		$this->firstResult = $firstResult;
		return $this;
	}

	public function			setMaxResults($maxResults)
	{
		$this->maxResults = $maxResults;
		return $this;
	}

	protected function		buildSql()
	{
		ksort($this->binds, SORT_STRING);
		$cacheKey = $this->jql;
		$bindsClasses = array();
		foreach ($this->binds as $name => $value) {
			$clazz = !is_object($value) ? is_null($value) ? 'void' : gettype($value) : get_class($value);
			$bindsClasses[$name] = $clazz;
			$cacheKey .= "\x01".$clazz;
		}

		if (is_null($result = \net\dryuf\core\Dryuf::getVmCached(__CLASS__, $this->cacheIdentifier, $cacheKey))) {
			$jqlTree = (new \net\dryuf\dao\phpjpa\parser\JqlParser())->parse($this->jql);
			$sqlBuilder = new SqlBuilder($this->entitiesConfig);
			$sqlBuilder->bindsClasses = $bindsClasses;
			$result = $jqlTree->visit($sqlBuilder);
			$sql = $result->getSql();
			if (!is_null($this->firstResult) || !is_null($this->maxResults))
				$sql = $this->dialect->addOffsetLimitRef($sql, $result->bindRefs, new BindRef(" offset", 1), new BindRef(" limit", 1));
			$result->setSqlString($sql);
			\net\dryuf\core\Dryuf::putVmCached(__CLASS__, $this->cacheIdentifier, $cacheKey, $result);
		}
		return $result;
	}

	public function			executeUpdate()
	{
		try {
			$result = $this->buildSql();
			if ($result->type != VisitResult::RT_Delete && $result->type != VisitResult::RT_Update)
				throw new \RuntimeException("expected DELETE or UPDATE statement for executeUpdate");

			$connection = $this->entitiesContext->getConnection();
			$statement = $connection->prepareStatement($result->getSql());
			$this->applyBinds($statement, $result->bindRefs);
			return $statement->executeUpdate();
		}
		catch (\net\dryuf\sql\SqlException $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			getResultList()
	{
		try {
			if (!is_null($this->firstResult)) {
				$this->binds[" offset"] = $this->firstResult;
				$this->binds[" limit"] = is_null($this->maxResults) ? 0x7fffffffffffffff : $this->maxResults;
			}
			else if (!is_null($this->maxResults)) {
				$this->binds[" offset"] = 0;
				$this->binds[" limit"] = $this->maxResults;
			}

			$result = $this->buildSql();
			if ($result->type != VisitResult::RT_Select)
				throw new \RuntimeException("expected SELECT statement for getResultList");

			$connection = $this->entitiesContext->getConnection();
			$statement = $connection->prepareStatement($result->getSql());
			$this->applyBinds($statement, $result->bindRefs);
			$rs = $statement->executeQuery();
			$output = new \net\dryuf\util\LinkedList();
			while (!is_null($row = $rs->nextAssoc())) {
				$output->add($this->convertResultRow($result->sourceDef, $row));
			}
			return $output;
		}
		catch (\net\dryuf\sql\SqlException $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			getSingleResult()
	{
		$output = $this->getResultList();
		if ($output->size() != 1) {
			throw $output->isEmpty() ? new \RuntimeException("no results for query ".$this->jql) : new \RuntimeException("too many results for query ".$this->jql.": ".$output->size());
		}
		return $output->get(0);
	}

	public function			applyBinds($statement, $bindRefs)
	{
		$sqlBinds = array();
		foreach ($bindRefs as $bindRef) {
			$bind = $this->binds[$bindRef->id];
			if (is_null($bind)) {
				for ($i = 0; $i < $bindRef->sqlArity; $i++)
					array_push($sqlBinds, null);
			}
			elseif (is_object($bind)) {
				$sqlArity = 0;
				$this->applyBindsClass($sqlBinds, $sqlArity, get_class($bind), $bind);
				if ($bindRef->sqlArity != $sqlArity)
					throw new \RuntimeException("Got object bind ".$bindRef->id." with sqlArity ".$bindRef->sqlArity." for sqlArity ".$sqlArity);
			}
			else {
				if ($bindRef->sqlArity != 1)
					throw new \RuntimeException("Got scalar bind ".$bindRef->id." for sqlArity ".$bindRef->sqlArity);
				array_push($sqlBinds, $bind);
			}
		}
		$statement->bindParams($sqlBinds);
	}

	public function			applyBindsClass(&$sqlBinds, &$counter, $clazz, $obj)
	{
		$jpaMeta = JpaMeta::openEmbedded($this->appContainer, $clazz, null, null);
		foreach ($jpaMeta->fields as $metaField) {
			if (!$metaField->isInDb())
				continue;
			$fieldValue = is_null($obj) ? null : $jpaMeta->getFieldValue($obj, $metaField->fieldName);
			if ($metaField->embeddedMeta) {
				$this->applyBindsClass($sqlBinds, $counter, $metaField->type, $fieldValue);
			}
			else {
				array_push($sqlBinds, $fieldValue);
				$counter++;
			}
		}
	}

	public function			convertPrimitive($value, $type)
	{
		switch ($type) {
		case 'byte':
		case 'short':
		case 'int':
		case 'integer':
		case 'long':
		case 'java.lang.Byte':
		case 'java.lang.Short':
		case 'java.lang.Integer':
		case 'java.lang.Long':
		case 'java\lang\Byte':
		case 'java\lang\Short':
		case 'java\lang\Integer':
		case 'java\lang\Long':
			return intval($value);

		case 'float':
		case 'double':
		case 'java.lang.Float':
		case 'java.lang.Double':
		case 'java\lang\Float':
		case 'java\lang\Double':
			return floatval($value);

		case 'string':
		case 'java.lang.String':
		case 'java\lang\String':
			return strval($value);

		case 'byte[]':
			return strval($value);

		default:
			return $value;
		}
	}

	public function			convertResultRow($sourceDef, $row)
	{
		$fieldSet = array();
		foreach ($sourceDef->fields as $columnDef) {
			if (!is_null($jpaMeta = $columnDef->jpaMeta)) {
				$i = 0;
				$obj = $this->convertClassColumns($columnDef->sqlFieldsAliases, $i, $jpaMeta, $row);
				if ($jpaMeta->isEntity())
					$obj = $this->entitiesContext->addToContext($jpaMeta, $obj);
				array_push($fieldSet, $obj);
			}
			else if (is_null($row[$columnDef->sqlFieldsAliases[0]])) {
				array_push($fieldSet, null);
			}
			else {
				array_push($fieldSet, $this->convertPrimitive($row[$columnDef->sqlFieldsAliases[0]], $columnDef->primitiveType));
			}
		}
		return count($fieldSet) == 1 ? $fieldSet[0] : $fieldSet;
	}

	public function			convertClassColumns($sqlFieldsAliases, &$aliasIndex, $jpaMeta, $row)
	{
		$pk = null;
		$result = \net\dryuf\core\Dryuf::createClassArg0($jpaMeta->clazz);
		foreach ($jpaMeta->fields as $metaField) {
			if ($metaField->isInDb()) {
				if ($metaField->embeddedMeta) {
					$value = $this->convertClassColumns($sqlFieldsAliases, $aliasIndex, $metaField->embeddedMeta, $row);
				}
				else {
					$value = $row[$sqlFieldsAliases[$aliasIndex++]];
				}
				$this->entitiesContext->setObjectField($result, new \ReflectionProperty(get_class($result), $metaField->fieldName), $value);
				if ($metaField->isPk)
					$pk = $value;
			}
			else if ($metaField->isMany()) {
				if (is_null($pk))
					throw new \RuntimeException("pk must come before any association, field: ".$metaField->fieldName);
				$this->entitiesContext->setObjectField($result, new \ReflectionProperty(get_class($result), $metaField->fieldName), new PersistenceList($this->entitiesContext, $metaField, $jpaMeta, $pk));
			}
			else {
				throw new \RuntimeException("unexpected metaField type: ".$metaField->metaType);
			}
		}
		return $result;
	}

	public function			convertExpression($sqlBuilder, $row, &$itemPosition)
	{
		return $row[$itemPosition++];
	}

	public				$appContainer;

	public				$entitiesConfig;

	public				$entitiesContext;

	public				$dialect;

	public				$cacheIdentifier;

	public				$jql;

	public				$firstResult;

	public				$maxResults;

	public				$binds;
}


?>
