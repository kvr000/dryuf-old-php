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

namespace net\dryuf\dao\phpjpa\test;


class RelationsTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	 * @javax.inject.Inject
	 * @javax.inject.Named(value = "javax.persistence.EntityManager-dryuf")
	 */
	protected			$em;

	/**
	 * @javax.inject.Inject
	 * @javax.inject.Named(value = "net.dryuf.transaction.TransactionManager-dryuf")
	 */
	protected			$transactionManager;

	function			runTransactionedNew($func)
	{
		$transaction = $this->transactionManager->openTransaction(false);
		try {
			$ret = $func();
			$transaction->commit();
			return $ret;
		}
		catch (\Exception $ex) {
			$transaction->rollback();
			throw $ex;
		}
	}

	/**
	 * @org.junit.Test
	 */
	function                        testOneToManyRelationship()
	{
		$q = $this->em->createQuery("SELECT p FROM DbConfigProfile p WHERE profileName = :profileName")->setParameter('profileName', 'net.dryuf.config.test.Config0Test');
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count is 1");
		$first = $result->get(0);
		\net\dryuf\tenv\DAssert::assertInstanceOf('net.dryuf.config.DbConfigProfile', $first, "net.dryuf.config.DbConfigProfile instance");
		\net\dryuf\tenv\DAssert::assertEquals('net.dryuf.config.test.Config0Test', $first->getProfileName(), "profileName correct");

		$q = $this->em->createQuery("SELECT s FROM DbConfigSection s WHERE pk = :section")->setParameter('section', new \net\dryuf\config\DbConfigSection\Pk('net.dryuf.config.test.Config0Test', 'section2'));
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count is 1");
		$first = $result->get(0);
		\net\dryuf\tenv\DAssert::assertInstanceOf('net.dryuf.config.DbConfigSection', $first, "net.dryuf.config.DbConfigSection instance");
		\net\dryuf\tenv\DAssert::assertEquals('net.dryuf.config.test.Config0Test', $first->getProfileName(), "profileName correct");
		\net\dryuf\tenv\DAssert::assertEquals('section2', $first->getSectionName(), "sectionName correct");
		$entries = $first->getEntries();
		\net\dryuf\tenv\DAssert::assertEquals(2, $entries->size());
		\net\dryuf\tenv\DAssert::assertEquals("key1", $entries->get(0)->getConfigKey());
		\net\dryuf\tenv\DAssert::assertEquals("key2", $entries->get(1)->getConfigKey());
		\net\dryuf\tenv\DAssert::assertEquals("val21", $entries->get(0)->getConfigValue());
		\net\dryuf\tenv\DAssert::assertEquals("val22", $entries->get(1)->getConfigValue());
	}
}


?>
