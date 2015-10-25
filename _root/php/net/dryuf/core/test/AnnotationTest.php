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

namespace net\dryuf\core\test;


class AnnotationTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	 * @org.junit.Test
	 */
	function                        testElements()
	{
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoParent', 'net\dryuf\core\test\TestAnnotationOne')->value());
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoParent', 'net\dryuf\core\test\TestAnnotationTwo')->value());
		\net\dryuf\tenv\DAssert::assertNull(\net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoParent', 'net\dryuf\core\test\TestAnnotationThree'));
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getMethodAnnotation('net\dryuf\core\test\AnnoParent', 'method', 'net\dryuf\core\test\TestAnnotationOne')->value());
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getMethodAnnotation('net\dryuf\core\test\AnnoParent', 'method', 'net\dryuf\core\test\TestAnnotationTwo')->value());
		\net\dryuf\tenv\DAssert::assertNull(\net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoParent', 'method', 'net\dryuf\core\test\TestAnnotationThree'));
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getFieldAnnotation('net\dryuf\core\test\AnnoParent', 'field', 'net\dryuf\core\test\TestAnnotationOne')->value());
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getFieldAnnotation('net\dryuf\core\test\AnnoParent', 'field', 'net\dryuf\core\test\TestAnnotationTwo')->value());
		\net\dryuf\tenv\DAssert::assertNull(\net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoParent', 'field', 'net\dryuf\core\test\TestAnnotationThree'));
	}

	/**
	 * @org.junit.Test
	 */
	function                        testDocAndAnnotation()
	{
		\net\dryuf\tenv\DAssert::assertEquals('parent', \net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoChild', 'net\dryuf\core\test\TestAnnotationOne')->value());
	}

	/**
	 * @org.junit.Test
	 */
	function                        testInheritance()
	{
		\net\dryuf\tenv\DAssert::assertEquals('value', \net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoWithDoc', 'net\dryuf\core\test\TestAnnotationOne')->value());
		\net\dryuf\tenv\DAssert::assertEquals('value', \net\dryuf\core\Dryuf::getClassAnnotation('net\dryuf\core\test\AnnoWithDoc', 'net\dryuf\core\test\TestAnnotationTwo')->value());
		\net\dryuf\tenv\DAssert::assertEquals('value', \net\dryuf\core\Dryuf::getMethodAnnotation('net\dryuf\core\test\AnnoWithDoc', 'method', 'net\dryuf\core\test\TestAnnotationOne')->value());
		\net\dryuf\tenv\DAssert::assertEquals('value', \net\dryuf\core\Dryuf::getMethodAnnotation('net\dryuf\core\test\AnnoWithDoc', 'method', 'net\dryuf\core\test\TestAnnotationTwo')->value());
		\net\dryuf\tenv\DAssert::assertEquals('value', \net\dryuf\core\Dryuf::getFieldAnnotation('net\dryuf\core\test\AnnoWithDoc', 'field', 'net\dryuf\core\test\TestAnnotationOne')->value());
		\net\dryuf\tenv\DAssert::assertEquals('value', \net\dryuf\core\Dryuf::getFieldAnnotation('net\dryuf\core\test\AnnoWithDoc', 'field', 'net\dryuf\core\test\TestAnnotationTwo')->value());
	}
}


?>
