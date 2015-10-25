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


class JpaTransactionHandler implements \net\dryuf\transaction\TransactionHandler
{
	public function			__construct($transactionManager, $readOnly)
	{
		$this->entityManager = $transactionManager->getEntityManager();
		$this->entityManager->pushContext();
		if ($readOnly)
			$this->setRollbackOnly();
	}

	public function			commit()
	{
		$entityManager = $this->entityManager;
		$this->entityManager = null;
		$entityManager->popContext(true);
	}

	public function			rollback()
	{
		$entityManager = $this->entityManager;
		$this->entityManager = null;
		if ($entityManager)
			$entityManager->popContext(false);
	}

	public function			getRollbackOnly()
	{
		return $this->entityManager ? $this->entityManager->getRollbackOnly() : true;
	}

	public function			setRollbackOnly()
	{
		if ($this->entityManager)
			$this->entityManager->setRollbackOnly();
	}

	public function			close()
	{
		$this->rollback();
	}

	protected			$entityManager;
}


?>
