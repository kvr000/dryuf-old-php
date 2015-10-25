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


class ObjectProxy
{
	protected function		__construct($target)
	{
		$this->__proxy_target = $target;
	}

	static function			createDirect($target)
	{
		return new self($target);
	}

	static function			createFunctional($creator)
	{
		$this_ = new self(null);
		$this_->__proxy_creator = $creator;
		return $this_;
	}

	function			_createTarget()
	{
		return $this->__proxy_target = call_user_func($this->__proxy_creator);
	}

	function			__call($name, $args)
	{
		if (is_null($target = $this->__proxy_target))
			$target = $this->_createTarget();
		return call_user_func_array(array($target, $name), $args);
	}

	function			__get($name)
	{
		if (is_null($target = $this->__proxy_target))
			$target = $this->_createTarget();
		return $target->$name;
	}

	function			__set($name, $value)
	{
		if (is_null($target = $this->__proxy_target))
			$target = $this->_createTarget();
		$target->$name = $value;
	}

	protected			$__proxy_target;
	protected			$__proxy_creator;
};


?>
