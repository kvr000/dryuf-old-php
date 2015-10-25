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


class PersistenceMethodSettings
{
	public				$unit;

	public				$attribute;
}

class PersistenceProxy
{
	function			__construct($processor, $target, $className, $defaultTransactional, $defaultAttribute)
	{
		$this->_proxy_processor = $processor;
		$this->_proxy_target = $target;
		$this->_proxy_className = $className;
		$this->_proxy_defaultTransactional = $defaultTransactional;
		$this->_proxy_defaultAttribute = $defaultAttribute;
	}

	function			_getTransactionalSettings($name)
	{
		if (!array_key_exists($name, $this->_proxy_settingsCache)) {
			if (!is_null($transactional = \net\dryuf\core\Dryuf::getMethodAnnotation($this->_proxy_className, $name, 'org.springframework.transaction.annotation.Transactional')) || !is_null($transactional = $this->_proxy_defaultTransactional)) {
				$settings = $this->_proxy_settingsCache[$name] = new PersistenceMethodSettings();
				$settings->unit = $transactional->value();
				if (is_null($attribute = \net\dryuf\core\Dryuf::getMethodAnnotation($this->_proxy_className, $name, 'javax.ejb.TransactionAttribute')))
					$attribute = $this->_proxy_defaultAttribute;
				$settings->attribute = $attribute->value();
			}
		}
		return $this->_proxy_settingsCache[$name];
	}

	function			__call($name, $args)
	{
		if (!is_null($settings = $this->_getTransactionalSettings($name))) {
			$transactionManager = $this->_proxy_processor->getTransactionManager($settings->unit);
			if (!is_null($transaction = $this->_acquireTransaction($transactionManager, $settings->attribute))) {
				try {
					$ret = call_user_func_array(array($this->_proxy_target, $name), $args);
					$transaction->commit();
				}
				catch (\Exception $ex) {
					$transaction->setRollbackOnly();
					if (!is_null($translatedEx = $transactionManager->tryTranslateException($ex)))
						$ex = $translatedEx;
					$transaction->rollback();
					throw $ex;
				}
				return $ret;
			}
		}
		return call_user_func_array(array($this->_proxy_target, $name), $args);
	}

	function			_acquireTransaction($transactionManager, $strategy)
	{
		switch ($strategy) {
		case \javax\ejb\TransactionAttributeType::MANDATORY:
			if (!$transactionManager->hasTransaction())
				throw new \RuntimeException("transaction not started while strategy is MANDATORY");
			$owner = false;
			return null;

		case \javax\ejb\TransactionAttributeType::NEVER:
			throw new \RuntimeException("strategy NEVER not implemented yet");
			if ($transactionManager->suspend())
				throw new \RuntimeException("transaction started while strategy is NEVER");
			$owner = false;
			return $transactionManager;

		case \javax\ejb\TransactionAttributeType::NOT_SUPPORTED:
			if ($transactionManager->hasTransaction())
				throw new \RuntimeException("transaction started while strategy is NOT_SUPPORTED");
			$owner = false;
			return null;

		case \javax\ejb\TransactionAttributeType::REQUIRED:
			if (!$transactionManager->hasTransaction()) {
				$owner = true;
				return $transactionManager->openTransaction(false);
			}
			else {
				$owner = false;
			}
			return null;

		case \javax\ejb\TransactionAttributeType::REQUIRES_NEW:
			$owner = true;
			return $transactionManager->openTransaction(false);

		case \javax\ejb\TransactionAttributeType::SUPPORTS:
			$owner = false;
			return null;

		default:
			throw new \RuntimeException("invalid strategy for creating transaction: $strategy");
		}
	}

	protected			$_proxy_processor;
	protected			$_proxy_target;
	protected			$_proxy_className;
	protected			$_proxy_defaultTransactional;
	protected			$_proxy_defaultAttribute;

	protected			$_proxy_settingsCache = array();
}

class PersistenceAopPostProcessor implements \net\dryuf\aop\AopPostProcessor, \net\dryuf\core\AppContainerAware
{
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		$this->appContainer = $appContainer;
	}

	public function			postProcessBean(\net\dryuf\core\AppContainer $appContainer, $original, $current, $params)
	{
		$proxy = null;
		$originalClassName = get_class($original);
		$originalClassRef = new \ReflectionClass($originalClassName);

		foreach (\net\dryuf\core\Dryuf::listFieldsByAnnotation($originalClassName, 'javax.persistence.PersistenceContext') as $field => $annotation) {
			$propertyRef = $originalClassRef->getProperty($field);
			$propertyRef->setAccessible(true);
			$propertyRef->setValue($original, $appContainer->getBean("javax.persistence.EntityManager-".$annotation->unitName()));
		}
		foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($originalClassName, 'javax.persistence.PersistenceContext') as $method => $annotation) {
			if (!preg_match('/^set(\w)(\w+)$/', $method, $match))
				throw new \RuntimeException("PersistenceContext used on non-setter: $method");
			$original->$method($appContainer->getBean("javax.persistence.EntityManager-".$annotation->unitName()));
		}

		if (!is_null($classTransactional = \net\dryuf\core\Dryuf::getClassAnnotation($originalClassName, 'org.springframework.transaction.annotation.Transactional'))) {
			if (is_null($classAttribute = \net\dryuf\core\Dryuf::getClassAnnotation($originalClassName, 'javax.ejb.TransactionAttribute')))
				$classAttribute = new \javax\ejb\TransactionAttribute(array("value" => \javax\ejb\TransactionAttributeType::$REQUIRED));
			$proxy = new \net\dryuf\dao\phpjpa\PersistenceProxy($this, $current, $originalClassName, $classTransactional, $classAttribute);
		}

		return is_null($proxy) ? $current : $proxy;
	}

	public function			getTransactionManager($unit)
	{
		return $this->appContainer->getBean("net.dryuf.transaction.TransactionManager-".$unit);
	}

	protected			$appContainer;

	protected			$transactionManagers;
};


?>
