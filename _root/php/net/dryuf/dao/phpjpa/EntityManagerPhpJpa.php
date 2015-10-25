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


class EntityManagerPhpJpa implements \javax\persistence\EntityManager, \net\dryuf\core\AppContainerAware
{
	public function			__construct()
	{
		$this->entitiesConfig = new \net\dryuf\dao\phpjpa\EntitiesConfig($this);
	}

	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		$this->appContainer = $appContainer;
		$this->entitiesConfig->initFromManager($this);
	}

	public function			setPersistenceUnit($unitName)
	{
		$this->entitiesConfig->setPersistenceUnit($unitName);
	}

	public function			setExceptionTranslator($exceptionTranslator)
	{
		$this->entitiesConfig->setExceptionTranslator($exceptionTranslator);
	}

	public function			createQuery($query)
	{
		try {
			return $this->getCurrentContext()->createQuery($query);
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			find($clazz, $pk)
	{
		try {
			return $this->getCurrentContext()->find($clazz, $pk);
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			persist($obj)
	{
		try {
			$this->getCurrentContext()->persist($obj);
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			merge($obj)
	{
		try {
			$this->getCurrentContext()->merge($obj);
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			remove($obj)
	{
		try {
			$this->getCurrentContext()->remove($obj);
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			flush()
	{
		try {
			$this->getCurrentContext()->flush();
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			createNativeQuery($query, $resultClass = null)
	{
		try {
			return $this->getCurrentContext()->createNativeQuery($query, $resultClass);
		}
		catch (\Exception $ex) {
			throw $this->entitiesConfig->getExceptionTranslator()->translateJpaException($ex);
		}
	}

	public function			hasContext()
	{
		return !is_null($this->currentContext);
	}

	public function			getCurrentContext()
	{
		if (is_null($currentContext = $this->currentContext))
			$currentContext = new EntitiesContext($this);
		return $currentContext;
	}

	public function			pushContext()
	{
		array_push($this->contextStack, $this->currentContext);
		return $this->currentContext = new EntitiesContext($this);
	}

	public function			popContext($commit)
	{
		$currentContext = $this->currentContext;
		$this->currentContext = array_pop($this->contextStack);
		$currentContext->closeContext($commit);
	}

	public function			getRollbackOnly()
	{
		return $this->currentContext->getRollbackOnly();
	}

	public function			setRollbackOnly()
	{
		$this->currentContext->setRollbackOnly();
	}

	public function			getAppContainer()
	{
		return $this->appContainer;
	}

	public function			getDataSource()
	{
		return $this->dataSource;
	}

	public function			getEntitiesConfig()
	{
		return $this->entitiesConfig;
	}

	public function			getDialect()
	{
		return $this->dialect;
	}

	protected			$appContainer;

	protected			$dataSource;

	protected			$entitiesConfig;

	protected			$currentContext;

	protected			$contextStack = array();

	protected			$dialect;
};


?>
