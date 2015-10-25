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

namespace javax\persistence;


class JoinColumn extends \net\dryuf\core\php\PhpAnnotationBase
{
	public function			columnDefinition() { return $this->__call("columnDefinition", array()); }
	public function			insertable() { return $this->__call("insertable", array()); }
	public function			name() { return $this->__call("name", array()); }
	public function			nullable() { return $this->__call("nullable", array()); }
	public function			referencedColumnName() { return $this->__call("referencedColumnName", array()); }
	public function			table() { return $this->__call("table", array()); }
	public function			unique() { return $this->__call("unique", array()); }
	public function			updatable() { return $this->__call("updatable", array()); }

	public function			__construct($args)
	{
		parent::__construct(array_merge(array(
				'columnDefinition' => "",
				'insertable' => true,
				'name' => '',
				'nullable' => true,
				'referencedColumnName' => '',
				'table' => '',
				'unique' => false,
				'updatable' => true,
			),
			$args
		));
	}
};


?>
