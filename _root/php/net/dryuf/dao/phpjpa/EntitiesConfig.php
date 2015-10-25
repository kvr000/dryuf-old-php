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


class EntitiesConfig
{
	public function			__construct(\net\dryuf\dao\phpjpa\EntityManagerPhpJpa $entityManager)
	{
	}

	public function			initFromManager(\net\dryuf\dao\phpjpa\EntityManagerPhpJpa $entityManager)
	{
		$this->appContainer = $entityManager->getAppContainer();
		$this->dialect = $entityManager->getDialect();
	}

	public function			setPersistenceUnit($persistenceUnit)
	{
		$this->persistenceUnit = $persistenceUnit;
	}

	public function			setExceptionTranslator($exceptionTranslator)
	{
		$this->exceptionTranslator = $exceptionTranslator;
	}

	public function			getPersistenceUnit()
	{
		return $this->persistenceUnit;
	}

	public function			resolveClassName($className)
	{
		if (is_null($this->entitiesHash)) {
			$this->entitiesHash = array();

			foreach ($this->appContainer->getConfigValue($this->persistenceUnit."-net.dryuf.jpa.entities") as $entity) {
				$normalized = \net\dryuf\core\Dryuf::dotClassname($entity);
				$tmp = explode(".", $normalized);
				$base = array_pop($tmp);
				$this->entitiesHash[$base] = $normalized;
				$this->entitiesHash[$entity] = $normalized;
			}
		}
		if (!isset($this->entitiesHash[$className]))
			throw new \RuntimeException("no such entity named ".$className);
		return $this->entitiesHash[$className];
	}

	public function			getAppContainer()
	{
		return $this->appContainer;
	}

	public function			getDialect()
	{
		return $this->dialect;
	}

	public function			getExceptionTranslator()
	{
		return $this->exceptionTranslator;
	}

	public function			getCacheIdentifier()
	{
		if (is_null($this->cacheIdentifier))
			$this->cacheIdentifier = $this->persistenceUnit."#".$this->getDialect()->getDialectName();
		return $this->cacheIdentifier;
	}

	protected			$appContainer;

	protected			$persistenceUnit;

	protected			$entitiesHash;

	protected			$dialect;

	protected			$exceptionTranslator;

	protected			$cacheIdentifier;
};


?>
