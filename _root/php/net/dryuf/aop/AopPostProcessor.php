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

namespace net\dryuf\aop;


/**
 * @brief
 * AOP bean post processor.
 *
 * This acts as an interface between application container and AOP functionality.
 * Once the bean is created application container passes the instance to AOP post processors in order to create proxy
 * chain that handles the functionality specified by AOP annotations.
 */
interface AopPostProcessor
{
	/**
	 * @brief
	 * Method is supposed to create a proxy for the bean according to recognized annotations.
	 *
	 * In case there are no annotations recognized by this post processor the function can simply return current
	 * proxy.
	 *
	 * @param dryuf::core::AppContainer $appContainer
	 * 	application container
	 * @param ::Object $original
	 * 	bean object
	 * @param ::Object $current
	 * 	currently top proxy for the bean
	 *
	 * @return
	 * 	the newly created proxy for the bean or the current proxy
	 */
	public function			postProcessBean(\net\dryuf\core\AppContainer $appContainer, $original, $current, $params);
};


?>
