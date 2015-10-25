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


class JpaMetaField
{
	const				MT_EMBEDDED			= 0;
	const				MT_REGULAR			= 1;
	const				MT_ASSOCIATION			= 2;
	const				MT_COMPOS			= 3;
	const				MT_SET				= 4;
	const				MT_LIST				= 5;

	public				$metaType			= self::MT_REGULAR;

	public				$fieldName			= null;
	public				$lcaseName			= null;
	public				$columnName			= null;

	public				$type;

	public				$getterName;
	public				$setterName;

	public				$generatedStrategy;

	public				$isPk				= false;

	public				$embeddedMeta			= null;

	public				$associationClass;
	public				$associationOrderBy;
	public				$joinColumns;

	public function			isRegular()
	{
		return $this->metaType == self::MT_REGULAR;
	}

	public function			isInDb()
	{
		return $this->metaType <= self::MT_ASSOCIATION;
	}

	public function			isAssociation()
	{
		return $this->metaType == self::MT_ASSOCIATION;
	}

	public function			isMany()
	{
		return $this->metaType >= self::MT_SET;
	}

	public function			isScalar()
	{
		return is_null($this->embeddedMeta);
	}

	public static			$PRIMITIVES = array(
		"boolean"			=> "boolean",
		"char"				=> "char",
		"short"				=> "short",
		"int"				=> "int",
		"integer"			=> "int",
		"long"				=> "long",
		"float"				=> "float",
		"double"			=> "double",
	);

	public static			$SCALARS = array(
		'java.lang.Number'		=> "String",
		'java\lang\Number'		=> "String",
		'java.lang.Boolean'		=> "Boolean",
		'java\lang\Boolean'		=> "Boolean",
		'java.lang.Byte'		=> "Short",
		'java\lang\Byte'		=> "Short",
		'java.lang.Short'		=> "Short",
		'java\lang\Short'		=> "Short",
		'java.lang.Integer'		=> "Integer",
		'java\lang\Integer'		=> "Integer",
		'java.lang.Long'		=> "Long",
		'java\lang\Long'		=> "Long",
		'java.lang.Float'		=> "Float",
		'java\lang\Float'		=> "Float",
		'java.lang.Double'		=> "Double",
		'java\lang\Double'		=> "Double",
		'java.lang.String'		=> "String",
		'byte[]'			=> "Binary",
	);

	public static			$SETS = array(
		'net.dryuf.util.Set'			=> self::MT_SET,
		'net.dryuf.util.List'			=> self::MT_LIST,
		'net\dryuf\util\Set'			=> self::MT_SET,
		'net\dryuf\util\List'			=> self::MT_LIST,
	);
};


class JpaMeta
{
	public static function		openEntity($appContainer, $clazz)
	{
		$clazz = \net\dryuf\core\Dryuf::convertClassname($clazz);
		if (is_null($this_ = \net\dryuf\core\Dryuf::getVmCached(__CLASS__, "meta", $clazz))) {
			$this_ = new self($appContainer, $clazz);
			$this_->parseEntity();
			\net\dryuf\core\Dryuf::putVmCached(__CLASS__, "meta", $clazz, $this_);
		}
		return $this_;
	}

	public static function		openEmbedded($appContainer, $clazz, $parentMeta, $overrideMapping)
	{
		$clazz = \net\dryuf\core\Dryuf::convertClassname($clazz);
		$this_ = new self($appContainer, $clazz);
		$this_->parseEmbedded($parentMeta, $overrideMapping);
		return $this_;
	}

	public static function		openEmbeddedCaching($appContainer, $clazz)
	{
		$clazz = \net\dryuf\core\Dryuf::convertClassname($clazz);
		if (is_null($this_ = \net\dryuf\core\Dryuf::getVmCached(__CLASS__, "metemb", $clazz))) {
			$this_ = new self($appContainer, $clazz);
			$this_->parseEmbedded(null, null);
			\net\dryuf\core\Dryuf::putVmCached(__CLASS__, "metemb", $clazz, $this_);
		}
		return $this_;
	}

	public static function		checkEmbedded($appContainer, $clazz, $parentMeta, $overrideMapping)
	{
		switch ($clazz) {
		case 'bool':
		case 'boolean':
		case 'byte':
		case 'short':
		case 'int':
		case 'integer':
		case 'long':
		case 'float':
		case 'double':
		case 'string':
		case 'java.lang.Boolean':
		case 'java.lang.Byte':
		case 'java.lang.Short':
		case 'java.lang.Integer':
		case 'java.lang.Long':
		case 'java.lang.Float':
		case 'java.lang.Double':
		case 'java.lang.String':
		case 'java\lang\Boolean':
		case 'java\lang\Byte':
		case 'java\lang\Short':
		case 'java\lang\Integer':
		case 'java\lang\Long':
		case 'java\lang\Float':
		case 'java\lang\Double':
		case 'java\lang\String':
			return null;

		default:
			return self::openEmbedded($appContainer, $clazz, $parentMeta, $overrideMapping);
		}
	}

	protected function		__construct($appContainer, $clazz)
	{
		$this->clazz = $clazz;
		$this->dotClazz = \net\dryuf\core\Dryuf::dotClassname($this->clazz);
		$this->classRef = new \ReflectionClass($this->clazz);
	}

	public function			isEntity()
	{
		return !is_null($this->tableName);
	}

	public function			getFieldMeta($name)
	{
		if (!isset($this->fieldsHash[$name])) {
			#var_dump($this->fieldsHash);
		}
		return $this->fieldsHash[$name];
	}

	public function			getFieldValue($object, $fieldName)
	{
		$fieldMeta = $this->getFieldMeta($fieldName);
		if (!is_null($getter = $fieldMeta->getter)) {
			return $object->$getter();
		}
		else {
			$propertyRef = $this->classRef->getProperty($fieldName);
			$propertyRef->setAccessible(true);
			return $propertyRef->getValue($object);
		}
	}

	public function			setFieldValue($object, $fieldName, $value)
	{
		$fieldMeta = $this->getFieldMeta($fieldName);
		if (!is_null($setter = $fieldMeta->setter)) {
			$object->$setter($value);
		}
		else {
			$propertyRef = $this->classRef->getProperty($fieldName);
			$propertyRef->setAccessible(true);
			$propertyRef->setValue($object, $value);
		}
	}

	public function			getPkMeta()
	{
		return $this->getFieldMeta($this->pkName);
	}

	public function			getPkValue($object)
	{
		return $this->getFieldValue($object, $this->pkName);
	}

	public function			setPkValue($object, $value)
	{
		return $this->setFieldValue($object, $this->pkName, $value);
	}

	protected function		parseCommon()
	{
		$this->fields = array();
		$this->fieldsHash = array();
		$this->columnsHash = array();

		$fieldTypeAnnos = \net\dryuf\core\Dryuf::listFieldsByAnnotation($this->clazz, 'net.dryuf.core.Type');
		foreach ($fieldTypeAnnos as $name => $typeAnno) {
			try {
				if ($typeAnno->isTransient())
					continue;
				$fieldMeta = new JpaMetaField();
				$fieldMeta->fieldName = $name;
				$fieldMeta->lcaseName = strtolower($name);
				$fieldMeta->type = $typeAnno->type();
				if (!is_null($column = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.Column'))) {
					$fieldMeta->columnName = $column->name();
				}
				else {
					$fieldMeta->columnName = $name;
				}
				$upperName = ucfirst($name);
				if ($this->classRef->hasMethod("get$upperName"))
					$fieldMeta->getter = "get$upperName";
				if ($this->classRef->hasMethod("set$upperName"))
					$fieldMeta->setter = "set$upperName";

				if (!is_null($oneToMany = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.OneToMany'))) {
					if (preg_match('/^([a-zA-Z_.\\\\]+)<(.+)>$/', $typeAnno->type(), $m)) {
						$fieldMeta->metaType = JpaMetaField::$SETS[$m[1]];
						$fieldMeta->associationClass = $m[2];
					}
					else {
						throw new \RuntimeException("Invalid OneToMany type: ".$typeAnno->type());
					}
					if (!is_null($joinColumnsAnno = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.JoinColumns'))) {
						$joinColumns = $joinColumnsAnno->value();
					}
					else if (!is_null($joinColumnAnno = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.JoinColumn'))) {
						$joinColumns = array($joinColumnAnno);
					}
					else {
						throw new \RuntimeException("JoinColumns not defined on $this->clazz.$name");
					}
					$fieldMeta->joinColumns = $joinColumns;
					if (!is_null($orderBy = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.OrderBy')))
						$fieldMeta->associationOrderBy = preg_split('/,\s*/', $orderBy->value());
				}
				else if (!is_null($manyToOne = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.ManyToOne'))) {
					throw new \RuntimeException("TODO");
				}
				else {
					$fieldMeta->embeddedMeta = self::checkEmbedded(null, $typeAnno->type(), $this, null);
				}

				if (!is_null($id = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.Id'))) {
					$fieldMeta->isPk = 1;
					$this->pkName = $name;
				}
				elseif (!is_null($embeddedId = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.EmbeddedId'))) {
					$fieldMeta->isPk = 1;
					$this->pkName = $name;
					$this->embeddedPkClazz = $typeAnno->type();
				}

				if (!is_null($generatedValue = \net\dryuf\core\Dryuf::getFieldAnnotation($this->clazz, $name, 'javax.persistence.GeneratedValue'))) {
					$fieldMeta->generatedStrategy = $generatedValue->strategy();
					$this->generatedField = $name;
				}

				array_push($this->fields, $fieldMeta);
				$this->fieldsHash[$name] = $fieldMeta;
				$this->columnsHash[$fieldMeta->columnName] = $fieldMeta;
			}
			catch (\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("Failed to process field $this->clazz.$name: ".strval($ex), $ex);
			}
		}
	}

	protected function		parseEntity()
	{
		$this->baseName = preg_replace('/^.*\./', '', $this->dotClazz);
		if (!is_null($table = \net\dryuf\core\Dryuf::getClassAnnotation($this->clazz, 'javax.persistence.Table'))) {
			$this->tableName = $table->name();
		}
		if (!$this->tableName) {
			$a = explode(".", \net\dryuf\core\Dryuf::dotClassname($this->clazz));
			$this->tableName = end($a);
		}

		$this->parseCommon();

		if (is_null($this->pkName))
			throw new \RuntimeException("did not find primary key on class $this->clazz");
	}

	protected function		parseEmbedded($parentMeta, $overrideMapping)
	{
		$this->tableName = is_null($parentMeta) ? null : $parentMeta->tableName;
		$this->embeddedOverride = $overrideMapping;

		$this->parseCommon();
	}

	/** Embedded indicator. */
	public				$embeddedOverride;

	/** ReflectionClass reference. */
	public				$classRef;

	/** Class to handle. */
	public				$clazz;

	/** Class to handle. */
	public				$dotClazz;

	/** Base name of the class. */
	public				$baseName;

	/** Name of SQL table. */
	public				$tableName;

	/** List of class fields. */
	public				$fields;

	/** Hash of class fields. */
	public				$fieldsHash;

	/** Hash of SQL columns => field definition. */
	public				$columnsHash;

	/** Primary key name. */
	public				$pkName;

	/** Class of embedded primary key. */
	public				$embeddedPkClazz;

	/** Name of generated field (if any). */
	public				$generatedField;

	public static			$cache;
};


?>
