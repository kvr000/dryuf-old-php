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

namespace net\dryuf\aop\php;


/**
 * @brief
 * Inject post processor.
 *
 * The implementation is responsible for injecting members within beans. It understands only javax.inject.Inject
 * annotation.
 */
class InjectPostProcessor implements \net\dryuf\aop\AopPostProcessor
{
	public function			postProcessBean(\net\dryuf\core\AppContainer $appContainer, $original, $current, $params)
	{
		$processed = array();

		$originalClassName = get_class($original);
		$classRef = new \ReflectionClass($originalClassName);

		foreach ($params as $key => $value) {
			if ($key == "")
				continue;
			$setter = "set".ucfirst($key);
			if ($classRef->hasMethod($setter)) {
				$original->$setter($value);
			}
			else {
				$propertyRef = $classRef->getProperty($key);
				$propertyRef->setAccessible(true);
				$propertyRef->setValue($original, $value);
			}
			$processed[$key] = true;
		}

		foreach (\net\dryuf\core\Dryuf::listFieldsByAnnotation($originalClassName, 'javax.inject.Inject') as $field => $annotation) {
			$name = $field;
			if (isset($processed[$name]))
				continue;
			if (!is_null($named = \net\dryuf\core\Dryuf::getFieldAnnotation($originalClassName, $field, "javax.inject.Named")))
				$name = $named->value();
			$propertyRef = $classRef->getProperty($field);
			$propertyRef->setAccessible(true);
			$propertyRef->setValue($original, $appContainer->getBean($name));
		}
		foreach (\net\dryuf\core\Dryuf::listMethodsByAnnotation($originalClassName, 'javax.inject.Inject') as $method => $annotation) {
			if (strpos($method, "set") !== 0)
				throw new \RuntimeException("Inject used on non-setter: $originalClassName.$method");
			$name = lcfirst(substr($method, 3));
			if (isset($processed[$name]))
				continue;
			if (!is_null($named = \net\dryuf\core\Dryuf::getMethodAnnotation($originalClassName, $method, "javax.inject.Named")))
				$name = $named->value();
			$original->$method($appContainer->getBean($name));
		}
		return $original;
	}
};


?>
