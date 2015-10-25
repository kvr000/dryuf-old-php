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


class NativeQueryPhpJpa extends \net\dryuf\dao\phpjpa\QueryPhpJpa
{
	public function			__construct(\net\dryuf\dao\phpjpa\EntitiesContext $entitiesContext, $sql, $resultClass)
	{
		parent::__construct($entitiesContext, $sql);

		$this->resultClass		= $resultClass;
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
		if (!is_null($this->firstResult) || !is_null($this->maxResults)) {
			$clazz = !is_object($this->firstResult) ? is_null($this->firstResult) ? 'void' : gettype($this->firstResult) : get_class($this->firstResult);
			$cacheKey .= "\x01".$clazz;
			$clazz = !is_object($this->maxResults) ? is_null($this->maxResults) ? 'void' : gettype($this->maxResults) : get_class($this->maxResults);
			$cacheKey .= "\x01".$clazz;
			$cacheKey .= "\x02"."ol";
		}
		$cacheKey .= "\x02"."nsql";

		if (is_null($result = \net\dryuf\core\Dryuf::getVmCached(__CLASS__, $this->cacheIdentifier, $cacheKey))) {
			$sql = $this->jql;
			$result = new VisitResult(VisitResult::RT_None);
			$bindCount = 0;
			for ($p = 0; $p < strlen($sql); ) {
				if (($quotePos = strpos($sql, "'", $p)) === false)
					$quotePos = -1;
				if (($questionPos = strpos($sql, "?", $p)) === false)
					$questionPos = -1;
				if (($colonPos = strpos($sql, ":", $p)) === false)
					$colonPos = -1;

				if ($questionPos >= 0 && ($quotePos < 0 || $quotePos > $questionPos) && ($colonPos < 0 || $colonPos > $questionPos)) {
					for ($p = $questionPos+1; $p < strlen($sql) && ctype_digit(substr($sql, $p, 1)); ++$p) ;
					$name = substr($sql, $questionPos+1, $p-$questionPos-1);
					$bindId = empty($name) ? strval(++$bindCount) : $name;
					array_push($result->bindRefs, new BindRef($bindId, 1));
					$sql = substr($sql, 0, $questionPos+1).substr($sql, $p);
				}
				elseif ($colonPos >= 0 && ($quotePos < 0 || $quotePos > $colonPos)) {
					# we do not support named parameters in native queries, just skip it
					$p = $colonPos+1;
				}
				elseif ($quotePos >= 0) {
					$escapeChar = $this->dialect->getQuoteEscape();
					for ($p = $quotePos+1; ; ) {
						if (($escapePos = strpos($sql, $escapeChar, $p)) === false)
							$escapePos = -1;
						if (($quotePos = strpos($sql, "'", $p)) === false)
							throw new \net\dryuf\core\RuntimeException("cannot find ending quote since position $p: $sql");
						if ($escapePos >= 0 && $escapePos < $quotePos) {
							# dialect either returns single escape character or double character, the second character is always the valid one
							$sql = substr($sql, 0, $escapePos).substr($sql, $escapePos+1);
							$p = $escapePos+1;
						}
						else {
							$p = $quotePos+1;
							break;
						}
					}
				}
				else {
					break;
				}
			}
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

			$connection = $this->entitiesContext->getConnection();
			$statement = $connection->prepareStatement($result->getSql());
			$this->applyBinds($statement, $result->bindRefs);
			$rs = $statement->executeQuery();
			$output = new \net\dryuf\util\LinkedList();

			if (is_null($this->resultClass)) {
				while (!is_null($rowArray = $rs->nextArray())) {
					$output->add($rowArray);
				}
			}
			elseif (\net\dryuf\core\ConversionUtil::isScalarClass($this->resultClass)) {
				while (!is_null($rowArray = $rs->nextArray())) {
					if (count($rowArray) != 1)
						throw new \net\dryuf\core\IllegalArgumentException("number of columns must be one for scalar conversion");
					$output->add(\net\dryuf\core\ConversionUtil::convertToClass($this->resultClass, $rowArray[0]));
				}
			}
			else {
				$jpaMeta = JpaMeta::openEmbeddedCaching($this->appContainer, $this->resultClass);
				while (!is_null($rowMap = $rs->nextAssoc())) {
					$output->add($this->convertResultMap($jpaMeta, $rowMap));
				}
			}
			return $output;
		}
		catch (\net\dryuf\sql\SqlException $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			convertResultMap($jpaMeta, &$row)
	{
		$result = \net\dryuf\core\Dryuf::createClassArg0($jpaMeta->clazz);
		foreach ($jpaMeta->fields as $metaField) {
			if ($metaField->embeddedMeta) {
				$value = $this->convertResultMap($metaField->embeddedMeta, $row);
			}
			else {
				if (array_key_exists($metaField->fieldName, $row)) {
					$value = $row[$metaField->fieldName];
				}
				elseif (array_key_exists($metaField->lcaseName, $row)) {
					$value = $row[$metaField->lcaseName];
				}
				elseif (isset($array["!lowered"])) {
					foreach ($array as $k => &$v) {
						$array[strtolower($k)] = $v;
					}
					$array["!lowered"] = true;
					if (array_key_exists($metaField->lcaseName, $row)) {
						$value = $row[$metaField->lcaseName];
					}
					else {
						continue;
					}
				}
				else {
					continue;
				}
				$value = \net\dryuf\core\ConversionUtil::convertToClass($metaField->type, $value);
			}
			$jpaMeta->setFieldValue($result, $metaField->fieldName, $value);
		}
		return $result;
	}

	public				$resultClass;
}


?>
