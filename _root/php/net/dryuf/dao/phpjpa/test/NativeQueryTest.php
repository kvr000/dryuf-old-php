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


class NativeQueryTest extends \net\dryuf\tenv\AppTenvObject
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

	function                        initTestMain()
	{
		return $this->runTransactionedNew(function () {
			$testMain = \net\dryuf\dao\jpa\JpaUtil::getSingleResultOptional($this->em->createQuery("SELECT tm FROM TestMain tm WHERE tm.svalue = ?1")
				->setParameter(1, __CLASS__));
			if (is_null($testMain)) {
				$testMain = new \net\dryuf\tenv\TestMain();
				$testMain->setIvalue(intval(microtime(true)*1000));
				$testMain->setName(__CLASS__);
				$testMain->setSvalue(__CLASS__);
				$this->em->persist($testMain);
			}
			return $testMain;
		});
	}

	function			cleanTestChilds($testMain)
	{
		$this->runTransactionedNew(function () use ($testMain) {
			$this->em->createQuery("DELETE FROM TestChild tc WHERE tc.pk.testId = ?1")
				->setParameter(1, $testMain->getTestId())
				->executeUpdate();
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
		$tm = $this->initTestMain();
		$this->cleanTestChilds($tm);
		for ($i = 1; $i <= $count; $i++) {
			$tc = new \net\dryuf\tenv\TestChild();
			$tc->setTestId($tm->getTestId());
			$tc->setChildId($i);
			$tc->setSvalue("child$i");
			$this->insertTestChild($tc);
		}
		return $tm;
	}

	/**
	 * @org.junit.Test
	 */
	function                        testScalarConversion()
	{
		$tm = $this->insertStructure(2);
		$r = $this->em->createNativeQuery("SELECT MIN(tc.childId) FROM TestChild tc WHERE tc.testId = ?1", 'java\lang\Integer')
			->setParameter(1, $tm->getTestId())
			->getSingleResult();
		\net\dryuf\tenv\DAssert::assertEquals('integer', gettype($r));
		\net\dryuf\tenv\DAssert::assertEquals(1, $r);
	}

	/**
	 * @org.junit.Test
	 */
	function                        testMultiConversion()
	{
		$tm = $this->insertStructure(2);
		$r = $this->em->createNativeQuery("SELECT MIN(tc.childId), MAX(tc.childId) FROM TestChild tc WHERE tc.testId = ?1")
			->setParameter(1, $tm->getTestId())
			->getSingleResult();
		\net\dryuf\tenv\DAssert::assertEquals(1, intval($r[0]));
		\net\dryuf\tenv\DAssert::assertEquals(2, intval($r[1]));
	}

	/**
	 * @org.junit.Test
	 */
	function                        testMapConversion()
	{
		$tm = $this->insertStructure(1);
		$r = $this->em->createNativeQuery("SELECT tc.testId, tc.svalue FROM TestChild tc WHERE tc.testId = ?1", 'net\dryuf\tenv\TestChild')
			->setParameter(1, $tm->getTestId())
			->setMaxResults(1)
			->getSingleResult();
		\net\dryuf\tenv\DAssert::assertInstanceOf('net\dryuf\tenv\TestChild', $r);
		\net\dryuf\tenv\DAssert::assertEquals($tm->getTestId(), $r->getTestId());
		\net\dryuf\tenv\DAssert::assertNull($r->getChildId());
		\net\dryuf\tenv\DAssert::assertEquals("child1", $r->getSvalue());
	}
}


?>
