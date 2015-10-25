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

namespace net\dryuf\sql;


interface ResultSet
{
	/**
	 * Fetches the next row
	 *
	 * @return false
	 * 	if there are no more rows
	 * @return true
	 * 	in case there is more data
	 */
	function			next();

	/**
	 * Fetches the next row
	 *
	 * @return null
	 * 	if there are no more rows
	 * @return indexed array
	 * 	in case there is more data, the row is returned as an array of
	 * 	values
	 */
	function			nextArray();

	/**
	 * Fetches the next row
	 *
	 * @return null
	 * 	if there are no more rows
	 * @return associate array
	 * 	in case there is more data, the row is returned as an associative array
	 */
	function			nextAssoc();

	/**
	 * Returns i (1-based) field from result set.
	 *
	 * @param i
	 * 	idnex of field, 1-based
	 * @return
	 *	the field value
	 */
	function			getObject($i);

	/**
	 * Returns current row as array.
	 *
	 * @return
	 *	array of fields
	 */
	function			getArray();

	/**
	 * Returns current row as map.
	 *
	 * @return
	 *	map of fields
	 */
	function			getMapped();

	/**
	 * Returns names of the fields.
	 *
	 * @return
	 *	array of names
	 */
	function			getNames();

	/**
	 * stores the result in the internal buffer
	 */
	function			store();

	/**
	 * closes the result set
	 *
	 * this is called automatically when the object is destroyed
	 */
	function			close();
};


?>
