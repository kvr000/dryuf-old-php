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


class EntityFunctionsTest extends \net\dryuf\tenv\AppTenvObject
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

	function                        cleanTestMain()
	{
		$this->runTransactionedNew(function () {
			$q = $em->createQuery("DELETE FROM TestMain");
			$q->executeUpdate();
		});
	}

	function                        insertTestMain($testMain)
	{
		$this->runTransactionedNew(function () {
			$em->persist($testMain);
		});
	}

	/**
	 * @org.junit.Test
	 */
	function                        testFind()
	{
		$userAccount = $this->em->find('net.dryuf.security.UserAccount', 1);
		\net\dryuf\tenv\DAssert::assertInstanceOf('net.dryuf.security.UserAccount', $userAccount, "UserAccount instance");
		\net\dryuf\tenv\DAssert::assertEquals(1, $userAccount->getUserId(), "userId == 1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testPersist()
	{
		$this->runTransactionedNew(function () {
			$tc = new \net\dryuf\tenv\TestMain();
			$tc->setName(__CLASS__.".testPersist");
			$tc->setSvalue("test");
			$this->em->persist($tc);
		});
	}

	/**
	 * @org.junit.Test
	 */
	function                        testChild()
	{
		$this->runTransactionedNew(function () {
			$tm = new \net\dryuf\tenv\TestMain();
			$tm->setName(__CLASS__.".testChild");
			$tm->setSvalue("test");
			$this->em->persist($tm);
			$this->em->createQuery("DELETE FROM TestChild")->executeUpdate();

			$ch = new \net\dryuf\tenv\TestChild();
			$ch->setTestId($tm->getPk());
			$ch->setChildId($tm->getPk()*10);
			$ch->setSvalue($tm->getPk()." hello");
			$this->em->persist($ch);
		});
	}

	/**
	 * @org.junit.Test
	 */
	function			testTransaction()
	{
		try {
			$this->runTransactionedNew(function () {
				$tm = new \net\dryuf\tenv\TestMain();
				$tm->setName(__CLASS__.".testTransaction");
				$tm->setSvalue(__CLASS__);
				$this->em->persist($tm);
				throw new \Exception("do rollback");
			});
		}
		catch (\Exception $ex) {
			$results = $this->em->createQuery("FROM TestMain WHERE svalue = :svalue")->setParameter("svalue", __CLASS__)->getResultList();
			\net\dryuf\tenv\DAssert::assertEquals(0, $results->size());
			return;
		}
		\net\dryuf\tenv\DAssert::fail("Expected exception");
	}
}


?>
