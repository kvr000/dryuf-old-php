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


class StatementsTest extends \net\dryuf\tenv\AppTenvObject
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
			$q = $this->em->createQuery("DELETE FROM TestMain");
			$q->executeUpdate();
		});
	}

	function                        insertTestMain($testMain)
	{
		$this->runTransactionedNew(function () use ($testMain) {
			$this->em->persist($testMain);
		});
	}

	function                        insertTestChild($testChild)
	{
		$this->runTransactionedNew(function () use ($testChild) {
			$this->em->persist($testChild);
		});
	}

	function			insertStructure($count)
	{
		$t = intval(microtime(true)*1000)%1000000000;
		$this->cleanTestMain();
		$tm = new \net\dryuf\tenv\TestMain();
		$tm->setName(__CLASS__);
		$tm->setIvalue($t);
		$tm->setSvalue("test0");
		$this->insertTestMain($tm);
		$tc = new \net\dryuf\tenv\TestChild();
		$tc->setTestId($tm->getTestId());
		for ($i = 1; $i <= $count; $i++) {
			$tc->setChildId($i);
			$tc->setSvalue("child$i");
			$this->insertTestChild($tc);
		}
		return $tm;
	}

	/**
	 * @org.junit.Test
	 */
	function                        testSelect()
	{
		$q = $this->em->createQuery("SELECT u FROM UserAccount u WHERE userId = ?1")->setParameter(1, 1);
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count");
		$first = $result->get(0);
		\net\dryuf\tenv\DAssert::assertInstanceOf('net.dryuf.security.UserAccount', $first, "UserAccount instance");
		\net\dryuf\tenv\DAssert::assertEquals(1, $first->getUserId(), "userId == 1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testFrom()
	{
		$q = $this->em->createQuery("FROM UserAccount WHERE userId = ?1")->setParameter(1, 1);
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count");
		$first = $result->get(0);
		\net\dryuf\tenv\DAssert::assertInstanceOf('net.dryuf.security.UserAccount', $first, "UserAccount instance");
		\net\dryuf\tenv\DAssert::assertEquals(1, $first->getUserId(), "userId == 1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testUpdate()
	{
		$this->cleanTestMain();
		$this->runTransactionedNew(function () {
			$tm = intval(microtime(true)*1000)%1000000000;
			$q = $this->em->createQuery("UPDATE TestMain SET ivalue = :ivalue WHERE testId = ?1")->setParameter("ivalue", $tm)->setParameter(1, 1);
			$result = $q->executeUpdate();
		});
	}

	/**
	 * @org.junit.Test
	 */
	function                        testDelete()
	{
		$tm = intval(microtime(true)*1000)%1000000000;
		$this->cleanTestMain();
		$tc = new \net\dryuf\tenv\TestMain();
		$tc->setIvalue($tm);
		$tc->setName(__CLASS__.".testDelete");
		$tc->setSvalue("test");
		$this->insertTestMain($tc);

		$this->runTransactionedNew(function () use ($tm) {
			$q = $this->em->createQuery("DELETE TestMain WHERE ivalue = :ivalue")->setParameter("ivalue", $tm);
			$q->executeUpdate();
		});
		$q = $this->em->createQuery("FROM TestMain WHERE ivalue = :ivalue")->setParameter("ivalue", $tm);
		$l = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(0, $l->size(), "empty after delete");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testSubSelect()
	{
		$q = $this->em->createQuery("SELECT u FROM UserAccount u WHERE u.userId IN (SELECT v.userId FROM UserAccount v WHERE v.userId = :userId)")->setParameter("userId", 1);
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count");
		$first = $result->get(0);
		\net\dryuf\tenv\DAssert::assertInstanceOf('net.dryuf.security.UserAccount', $first, "UserAccount instance");
		\net\dryuf\tenv\DAssert::assertEquals(1, $first->getUserId(), "userId == 1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testSelectMulti()
	{
		$q = $this->em->createQuery("SELECT u, u another, v.username, 66 intnum, 2.718 realnum, 'abc' apstr, \"xyz\" qstr, NULL nulllit, 4 FROM UserAccount u, UserAccount v WHERE u.userId = v.userId AND u.userId = ?1")->setParameter(1, 1);
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count");
		$first = $result->get(0);
		\net\dryuf\tenv\DAssert::assertEquals(66, $first[3], "int");
		\net\dryuf\tenv\DAssert::assertEqualsPercent1(2.718, $first[4], "float");
		\net\dryuf\tenv\DAssert::assertEquals("abc", $first[5], "string");
		\net\dryuf\tenv\DAssert::assertEquals("xyz", $first[6], "quoted");
		\net\dryuf\tenv\DAssert::assertNull($first[7], "null");
		\net\dryuf\tenv\DAssert::assertEquals(4, $first[8], "four");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testSelectOrder()
	{
		$t = intval(microtime(true)*1000)%1000000000;
		$this->cleanTestMain();
		$tm = new \net\dryuf\tenv\TestMain();
		$tm->setIvalue($t);
		$tm->setName(__CLASS__.".testSelectOrder-1");
		$tm->setSvalue("test1");
		$this->insertTestMain($tm);
		$tm->setName(__CLASS__.".testSelectOrder-2");
		$tm->setSvalue("test2");
		$this->insertTestMain($tm);
		$tm->setName(__CLASS__.".testSelectOrder-4");
		$tm->setSvalue("test4");
		$this->insertTestMain($tm);
		$tm->setName(__CLASS__.".testSelectOrder-3");
		$tm->setSvalue("test3");
		$this->insertTestMain($tm);

		$q = $this->em->createQuery("SELECT t FROM TestMain t ORDER BY t.svalue DESC")->setParameter(1, 1);
		$results = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(4, $results->size(), "result count");
		\net\dryuf\tenv\DAssert::assertEquals("test4", $results->get(0)->getSvalue(), "test4");
		\net\dryuf\tenv\DAssert::assertEquals("test3", $results->get(1)->getSvalue(), "test3");
		\net\dryuf\tenv\DAssert::assertEquals("test2", $results->get(2)->getSvalue(), "test2");
		\net\dryuf\tenv\DAssert::assertEquals("test1", $results->get(3)->getSvalue(), "test1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testSelectMember()
	{
		$tm = $this->insertStructure(2);

		$q = $this->em->createQuery("SELECT tc.pk.childId FROM TestChild tc WHERE tc.pk.testId = ?1 ORDER BY tc.svalue DESC")->setParameter(1, $tm->getTestId());
		$results = $q->getResultList();
	}

	/**
	 * @org.junit.Test
	 */
	function                        testOrderMember()
	{
		$tm = $this->insertStructure(3);

		$q = $this->em->createQuery("SELECT tc.pk.childId FROM TestChild tc WHERE tc.pk.testId = ?1 ORDER BY tc.pk.childId DESC")->setParameter(1, $tm->getTestId());
		$results = $q->getResultList();
	}

	/**
	 * @org.junit.Test
	 */
	function                        testOrderComposite()
	{
		$tm = $this->insertStructure(3);

		$q = $this->em->createQuery("SELECT tc.pk.childId FROM TestChild tc WHERE tc.pk.testId = ?1 ORDER BY tc.pk DESC")->setParameter(1, $tm->getTestId());
		$results = $q->getResultList();
	}

	/**
	 * @org.junit.Test
	 */
	function                        testAggregate()
	{
		$tm = $this->insertStructure(3);

		$q = $this->em->createQuery("SELECT SUM(tc.pk.childId) FROM TestChild tc WHERE tc.pk.testId = ?1 ORDER BY tc.pk.childId DESC")->setParameter(1, $tm->getTestId());
		$results = $q->getResultList();
		$r = $q->getSingleResult();
		\net\dryuf\tenv\DAssert::assertEquals(6, $r, "sum is 6");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testFunction()
	{
		$tm = $this->insertStructure(0);

		$q = $this->em->createQuery("SELECT currentTimeMillis() FROM TestMain tm")->setMaxResults(1);
		$results = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $results->size(), "items == 1");
		\net\dryuf\tenv\DAssert::assertTrue(abs($results->get(0)-microtime(true)*1000) < 10000, "time call: ".$results->get(0));
	}

	/**
	 * @org.junit.Test
	 */
	function                        testCase()
	{
		$tm = $this->insertStructure(1);

		$q = $this->em->createQuery("SELECT CASE WHEN tc.pk.testId < 0 THEN -1 WHEN tc.pk.testId > 0 THEN 1 ELSE 0 END FROM TestChild tc WHERE tc.pk.testId = :testId")->setParameter("testId", $tm->getTestId());
		$r = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $r->get(0), "sign == 1");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testStar()
	{
		$tm = $this->insertStructure(7);

		$q = $this->em->createQuery("SELECT COUNT(*) FROM TestChild tc WHERE tc.pk.testId = :testId")->setParameter("testId", $tm->getTestId());
		$r = $q->getSingleResult();
		\net\dryuf\tenv\DAssert::assertEquals(7, $r, "count == 7");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testTuples()
	{
		$q = $this->em->createQuery("SELECT u FROM UserAccount u WHERE u.userId = :userId AND ( 1, 1 ) = ( 1, 1 )")->setParameter("userId", 1);
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(1, $result->size(), "result count");
	}

	/**
	 * @org.junit.Test
	 */
	function                        testIdentifierTuple()
	{
		$q = $this->em->createQuery("SELECT pk.domain FROM UserAccountDomainRole udr WHERE pk.domain = :domain")->setParameter("domain", new \net\dryuf\security\UserAccountDomain\Pk(1, "dryuf"));
		$result = $q->getResultList();
		\net\dryuf\tenv\DAssert::assertEquals(0, $result->size(), "result count");
	}

	/**
	 * @org.junit.Test
	 */
	function                        benchSelect()
	{
		for ($i = 0; $i < (0 ? 1000 : 1); $i++) {
			$q = $this->em->createQuery("SELECT u, u another, v.username, 66 intnum, 2.718 realnum, 'abc' apstr, \"xyz\" qstr, NULL nulllit, 4 FROM UserAccount u, UserAccount v WHERE u.userId = v.userId AND u.userId = ?1")->setParameter(1, 1);
			$results = $q->getResultList();
		}
	}
}


?>
