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

namespace net\dryuf\core\php;


class PhpAppContainer implements \net\dryuf\core\AppContainer
{
	public function			__construct($workRoot, $appConfig)
	{
		$this->workRoot = $workRoot;
		$this->appConfig = $appConfig;
		$this->appRoot = $appConfig['appRoot'];
		$this->config = $appConfig['config'];
		$this->beans = $appConfig['beans'];
		$this->aops = $appConfig['aops'];
		$this->rolesDependencies = $appConfig['rolesDependencies'];

		$this->proxyBeans = array("appContainer" => $this);
		$this->createdBeans = array("appContainer" => $this);

		if (is_null(\net\dryuf\core\Dryuf::$dataCache))
			\net\dryuf\core\Dryuf::$dataCache = \net\dryuf\core\Dryuf::createClassArg0($this->config['net.dryuf.core.dataCacheClazz']);

		foreach ($this->aops as $aop) {
			if ($aop instanceof \net\dryuf\core\AppContainerAware)
				$aop->afterAppContainer($this);
		}
	}

	public function			getWorkRoot()
	{
		return $this->workRoot;
	}

	public function			getAppRoot()
	{
		return $this->appRoot;
	}

	public function			getConfigValue($name, $defaultValue = null)
	{
		return isset($this->config[$name]) ? $this->config[$name] : $defaultValue;
	}

	public function			getCpResource($path)
	{
		if (($streamName = stream_resolve_include_path($path)) === false)
			throw new \net\dryuf\io\FileNotFoundException($path);
		return fopen($streamName, "r");
	}

	public function			getCpResourceContent($path)
	{
		return stream_get_contents($this->getCpResource());
	}

	public function			getResource($filename)
	{
		$fd = substr($filename, 0, 10) == "classpath:" ? $this->getCpResource(substr($filename, 10)) : fopen($this->appRoot.$filename, "r");
		$fstat = fstat($fd);
		$fileData = new \net\dryuf\io\FileDataImpl();
		$fileData->setContentType(null);
		$fileData->setSize($fstat['size']);
		$fileData->setModifiedTime($fstat['mtime']);
		$fileData->setInputStream($fd);
		return $fileData;
	}

	public function			getResourceContent($file)
	{
		return stream_get_contents($this->getResourceContent()->getInputStream());
	}

	public function			getResourcePaths($path)
	{
		if (substr($path, 0, 1) != "/")
			$path = "/".$path;
		return \net\dryuf\io\DirUtil::filterEntries(function($file) use ($path) { $relative = $path.$file; $full = $this->appRoot.$relative; return is_dir($full) ? $file."/" : $file; }, $this->appRoot.$path);
	}

	public function			createCallerContext()
	{
		return new \net\dryuf\srvui\php\PhpCallerContext($this);
	}

	public function			getAutowireCapableBeanFactory()
	{
		return $this;
	}

	public function			getParent()
	{
		return null;
	}

	public function			getStartupDate()
	{
		return floor(microtime(true)*1000);
	}

	public function			getMessage($code, $args, $locale)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("unsupported yet");
	}

	public function			getBean($beanName)
	{
		if (isset($this->createdBeans[$beanName]))
			return $this->createdBeans[$beanName];
		if (isset($this->proxyBeans[$beanName]))
			return $this->proxyBeans[$beanName];
		if (!isset($this->beans[$beanName]))
			throw new \net\dryuf\core\NoSuchBeanException("No bean of name ".$beanName);
		return $this->proxyBeans[$beanName] = \net\dryuf\aop\ObjectProxy::createFunctional(function () use ($beanName) { return $this->getRealBean($beanName); });
	}

	public function			getBeanTyped($beanName, $clazz)
	{
		return $this->getBean($beanName);
	}

	public function			postProcessBean($bean, $name, $params)
	{
		if (!$params)
			$params = array();
		$current = $bean;
		foreach ($this->aops as $aopPostProcessor) {
			$current = $aopPostProcessor->postProcessBean($this, $bean, $current, $params);
		}
		if ($bean instanceof \net\dryuf\core\AppContainerAware)
			$bean->afterAppContainer($this);
		return $current;
	}

	public function			getRealBean($beanName)
	{
		if (!isset($this->createdBeans[$beanName])) {
			try {
				$this->createdBeans[$beanName] = call_user_func($this->beans[$beanName], $this, $beanName);
			}
			catch (\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("Error creating bean $beanName: ".$ex->getMessage(), $ex);
			}
		}
		return $this->createdBeans[$beanName];
	}

	public function			createBeaned($clazz, $injects)
	{
		$bean = new $clazz();
		return $this->injectBean($bean, $injects);
	}

	public function			createBeanedArgs($clazz, $args, $injects)
	{
		$refl = new ReflectionClass($clazz);
		$bean = $refl->newInstanceArgs($args);
		return $this->injectBean($bean, $injects);
	}

	public function			injectBean($bean, $injects)
	{
		if (is_null($injects))
			$injects = \net\dryuf\util\MapUtil::$EMPTY_MAP;
		if (is_null($this->injectPostProcessor))
			$this->injectPostProcessor = new \net\dryuf\aop\php\InjectPostProcessor();
		return $this->injectPostProcessor->postProcessBean($this, $bean, $bean, $injects);
	}

	public function			getGlobalRoles()
	{
		return array_keys($this->rolesDependencies);
	}

	public function			checkRoleDependency($roleName)
	{
		return $this->rolesDependencies[$roleName];
	}

	public function			getCreatedBeansCount()
	{
		return count($this->createdBeans);
	}

	protected			$rolesDependencies;

	protected			$appConfig;

	protected			$workRoot;
	protected			$config;
	protected			$beans;

	protected			$proxyBeans;
	protected			$createdBeans;

	protected			$aops;

	protected			$injectPostProcessor;
};


?>
