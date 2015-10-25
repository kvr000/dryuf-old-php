<?php

namespace net\dryuf\sql;


/**
 * Helper class for SQL queries
 */
class SqlHelper extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	 * Sets autocommit on existing connection
	 * 
	 * @param dataSource
	 * 	SQL data source
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\sql\Connection')
	*/
	public static function		getDataSourceConnection($dataSource)
	{
		try {
			return $dataSource->getConnection();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Sets autocommit on existing connection
	 * 
	 * @param connection
	 * 	SQL connection
	 * @param autoCommit
	 * 	the new status of auto commit
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		setAutoCommit($connection, $autoCommit)
	{
		try {
			$connection->setAutoCommit($autoCommit);
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Closes connection.
	 * 
	 * @param connection
	 * 	SQL connection
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		closeConnection($connection)
	{
		try {
			$connection->close();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Commits connection.
	 * 
	 * @param connection
	 * 	SQL connection
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		commitConnection($connection)
	{
		try {
			$connection->commit();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Rolls back connection.
	 * 
	 * @param connection
	 * 	SQL connection
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		rollbackConnection($connection)
	{
		try {
			$connection->rollback();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Caches a statement provided as string+
	 * 
	 * @return
	 * 	the prepared statement
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\sql\PreparedStatement')
	*/
	public static function		cacheString($connection, $name, $statement)
	{
		try {
			return $connection->prepareStatement($statement);
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Queries field for specified table and filter+
	 * Exactly one row is expected
	 * 
	 * @param connection
	 * 	the database connection to use
	 * @param field
	 * 	the required field
	 * @param table
	 * 	table name
	 * @param filter
	 * 	filter column name
	 * @param filterValue
	 * 	the value for filtered column
	 * 
	 * @return
	 * 	field value
	 * 
	 * @note
	 * 	Throws an exception if not exactly one row is found
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		queryOneField($connection, $field, $table, $filter, $filterValue)
	{
		try {
			$ststr = "SELECT ".$field." FROM ".$table." WHERE ".$filter." = ?";
			$st = $connection->prepareStatement($ststr);
			$st->bindParams(array($filterValue));
			$rs = $st->executeQuery();
			if ($rs->next()) {
				if ($rs->next()) {
					throw new \javax\persistence\NonUniqueResultException("more than one row found for statement ".$ststr);
				}
				return $rs->getObject(1);
			}
			else {
				throw new \javax\persistence\NoResultException("no row found for statement ".$ststr);
			}
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Queries at most one row+
	 * Null is returned in case now row is found
	 * 
	 * @param connection
	 * 	the database connection to use
	 * @param statement
	 * 	statement with ? binds
	 * @param binds
	 * 	bind variables for the statement
	 * 
	 * @return null
	 * 	if no row is found
	 * @return result
	 * 	as an associative array of the retrieved columns
	 * 
	 * @note
	 * 	Throws an exception if more than one row is found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public static function		queryRow($connection, $statement, $binds)
	{
		try {
			$st = \net\dryuf\sql\SqlHelper::bindParams($connection->prepareStatement($statement), $binds);
			$rs = $st->executeQuery();
			if (!is_null(($rowMap = \net\dryuf\sql\SqlHelper::fetchMap($rs)))) {
				if ($rs->next()) {
					throw new \javax\persistence\NonUniqueResultException("more than one row found for statement ".$statement);
				}
				return $rowMap;
			}
			else {
				return null;
			}
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Queries exactly one row
	 * 
	 * @param connection
	 * 	the database connection to use
	 * @param statement
	 * 	statement with ? binds
	 * @param binds
	 * 	bind variables for the statement
	 * 
	 * @return result
	 * 	as an associative array of the retrieved columns
	 * 
	 * @note
	 * 	Throws an exception if not exactly one row is found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public static function		queryOneRow($connection, $statement, $binds)
	{
		if (is_null(($row = \net\dryuf\sql\SqlHelper::queryRow($connection, $statement, $binds))))
			throw new \javax\persistence\NoResultException("no row found for statement ".$statement);
		return $row;
	}

	/**
	 * Queries a single column
	 * 
	 * @return null
	 * 	either if the column is null or now row is returned at all
	 * @return
	 * 	the value of the first column
	 * 
	 * @throw net.dryuf.sql.SqlTooManyRowsException
	 * 	if more than one row is returned
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		queryColumn($connection, $statement, $binds)
	{
		try {
			$st = $connection->prepareStatement($statement);
			\net\dryuf\sql\SqlHelper::bindParams($st, $binds);
			$rs = $st->executeQuery();
			if ($rs->next()) {
				if ($rs->next()) {
					throw new \javax\persistence\NonUniqueResultException("more than one row found for statement ".$statement);
				}
				return $rs->getObject(1);
			}
			else {
				return null;
			}
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Queries a single column
	 * 
	 * @return
	 * 	the value of the first column
	 * 
	 * @throw net.dryuf.sql.SqlNoDataException
	 * 	if no row is returned
	 * @throw net.dryuf.sql.SqlTooManyRowsException
	 * 	if more than one row is returned
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		queryOneColumn($connection, $statement, $binds)
	{
		try {
			$st = \net\dryuf\sql\SqlHelper::bindParams($connection->prepareStatement($statement), $binds);
			$rs = $st->executeQuery();
			if ($rs->next()) {
				if ($rs->next()) {
					throw new \javax\persistence\NonUniqueResultException("more than one row found for statement ".$statement);
				}
				return $rs->getObject(1);
			}
			else {
				throw new \javax\persistence\NoResultException("no row found for statement ".$statement);
			}
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * query rows and returns them as array of associative arrays
	 * 
	 * @return
	 * 	the array of rows as associative arrays (even if empty)
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\util\Map<java\lang\String, java\lang\Object>>')
	*/
	public static function		queryRows($connection, $statement, $binds)
	{
		try {
			$st = \net\dryuf\sql\SqlHelper::bindParams($connection->prepareStatement($statement), $binds);
			$rs = $st->executeQuery();
			$rows = new \net\dryuf\util\LinkedList();
			while (!is_null(($rowMap = \net\dryuf\sql\SqlHelper::fetchMap($rs)))) {
				$rows->add($rowMap);
			}
			return $rows;
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs an non-result statement
	 * 
	 * @return
	 * 	the number of rows modified
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		updateAny($connection, $statement, $binds)
	{
		try {
			return \net\dryuf\sql\SqlHelper::bindParams($connection->prepareStatement($statement), $binds)->executeUpdate();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs an non-result statement, expecting exactly one match
	 * 
	 * @return 1
	 * 
	 * @note
	 * 	throws an exception if less or more than one row is updated
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		updateOneRow($connection, $statement, $binds)
	{
		$count = \net\dryuf\sql\SqlHelper::updateAny($connection, $statement, $binds);
		if ($count != 1)
			throw new \javax\persistence\NonUniqueResultException("updated ".$count." rows, expected one");
		return 1;
	}

	/**
	 * runs a prepared query with specified bindings
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the result set
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\sql\ResultSet')
	*/
	public static function		executeResult($statement, $binds)
	{
		try {
			$rs = \net\dryuf\sql\SqlHelper::bindParams($statement, $binds)->executeQuery();
			return $rs;
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared query with specified bindings
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the list of queried rows as array of hashes
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\util\Map<java\lang\String, java\lang\Object>>')
	*/
	public static function		executeRows($statement, $binds)
	{
		try {
			$rs = \net\dryuf\sql\SqlHelper::bindParams($statement, $binds)->executeQuery();
			$rows = new \net\dryuf\util\LinkedList();
			if (!is_null(($rowMap = \net\dryuf\sql\SqlHelper::fetchMap($rs)))) {
				$rows->add($rowMap);
			}
			return $rows;
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared query with specified bindings
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the list of queried row as hash or null if no row is found
	 * 
	 * @note
	 * 	Throws an exception when more than one row is found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public static function		executeRow($statement, $binds)
	{
		try {
			$rs = \net\dryuf\sql\SqlHelper::bindParams($statement, $binds)->executeQuery();
			if (is_null(($rowMap = \net\dryuf\sql\SqlHelper::fetchMap($rs))))
				return null;
			if ($rs->next())
				throw new \javax\persistence\NonUniqueResultException("query returned more than a single row");
			return $rowMap;
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared query with specified bindings
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the list of queried row as hash
	 * 
	 * @note
	 * 	Throws an exception when not exactly one row is found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public static function		executeOneRow($statement, $binds)
	{
		try {
			$rs = \net\dryuf\sql\SqlHelper::executeResult($statement, $binds);
			if (is_null(($rowMap = \net\dryuf\sql\SqlHelper::fetchMap($rs))))
				throw new \javax\persistence\NoResultException();
			if ($rs->next())
				throw new \javax\persistence\NonUniqueResultException();
			return $rowMap;
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared query with specified bindings and returns the first column
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return null
	 * 	if no row is found
	 * @return
	 * 	the list of queried row as hash or null if no row is found
	 * 
	 * @note
	 * 	Throws an exception when more than one row is returned
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		executeColumn($statement, $binds)
	{
		try {
			$rs = \net\dryuf\sql\SqlHelper::executeResult($statement, $binds);
			if (!$rs->next())
				return null;
			if ($rs->next())
				throw new \javax\persistence\NonUniqueResultException();
			return $rs->getObject(1);
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared query with specified bindings and returns the first column
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the list of queried row as hash or null if no row is found
	 * 
	 * @note
	 * 	Throws an exception when not exactly one row is returned
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		executeOneColumn($statement, $binds)
	{
		try {
			$rs = \net\dryuf\sql\SqlHelper::executeResult($statement, $binds);
			if (!$rs->next())
				throw new \javax\persistence\NoResultException();
			if ($rs->next())
				throw new \javax\persistence\NonUniqueResultException();
			return $rs->getObject(1);
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared update-type with specified bindings and returns the
	 * number of rows affected
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the number of rows affected
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		executeUpdateAny($statement, $binds)
	{
		try {
			return \net\dryuf\sql\SqlHelper::bindParams($statement, $binds)->executeUpdate();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a prepared update-type with specified bindings and checks exactly one row was updated
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the number of rows updated, i.e. 1
	 * 
	 * @note
	 * 	throws an exception when not exactly one row was updated
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		executeUpdateOne($statement, $binds)
	{
		if (($c = \net\dryuf\sql\SqlHelper::executeUpdateAny($statement, $binds)) != 1) {
			if ($c == 0)
				throw new \javax\persistence\NoResultException("query did not udpate exactly one row");
			else
				throw new \javax\persistence\NonUniqueResultException("query did not udpate exactly one row");
		}
		return $c;
	}

	/**
	 * runs a prepared insert with specific bindings and returns the last insert
	 * 
	 * @param statement
	 * 	the prepared statement
	 * @param binds
	 * 	bind variables for this query
	 * 
	 * @return
	 * 	the newly generated serial id
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		executeInsertSerial($statement, $binds)
	{
		try {
			$c = \net\dryuf\sql\SqlHelper::bindParams($statement, $binds)->executeUpdate();
			if ($c != 1) {
				if ($c == 0)
					throw new \javax\persistence\NoResultException("query did not udpate exactly one row");
				else
					throw new \javax\persistence\NonUniqueResultException("query did not udpate exactly one row");
			}
			return \net\dryuf\sql\SqlHelper::getInsertId($statement);
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a dynamic insert statement
	 * 
	 * @param connection
	 * 	the connection
	 * @param table
	 * 	table name
	 * @param values
	 * 	hash list of column: value
	 * 
	 * @return
	 * 	the number of affected columns
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		runInsert($connection, $table, $values)
	{
		try {
			$sb = (new \net\dryuf\core\StringBuilder("INSERT INTO "))->append($table)->append(" (");
			$c = "";
			$v = "";
			foreach ($values->keySet() as $key) {
				$sb->append($key)->append(", ");
			}
			$sb->replace($sb->length()-2, $sb->length(), ") VALUES (");
			$binds = $values->values()->toArray(\net\dryuf\core\Dryuf::allocArray(null, $values->size()));
			foreach ($binds as $b) {
				$sb->append("?, ");
			}
			$sb->replace($sb->length()-2, $sb->length(), ")");
			$st = $connection->prepareStatement(strval($sb));
			\net\dryuf\sql\SqlHelper::bindParams($st, $binds);
			return $st->executeUpdate();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a dynamic insert statement, returning the insert id
	 * 
	 * @param connection
	 * 	the connection
	 * @param table
	 * 	table name
	 * @param values
	 * 	hash list of column, value
	 * 
	 * @return
	 * 	the serial inserted id
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		runInsertSerial($connection, $table, $values)
	{
		try {
			$sb = (new \net\dryuf\core\StringBuilder("INSERT INTO "))->append($table)->append(" (");
			$c = "";
			$v = "";
			foreach ($values->keySet() as $key) {
				$sb->append($key)->append(", ");
			}
			$sb->replace($sb->length()-2, $sb->length(), ") VALUES (");
			$binds = $values->values()->toArray(\net\dryuf\core\Dryuf::allocArray(null, $values->size()));
			foreach ($binds as $b) {
				$sb->append("?, ");
			}
			$sb->replace($sb->length()-2, $sb->length(), ")");
			return \net\dryuf\sql\SqlHelper::executeInsertSerial($connection->prepareStatement(strval($sb)), $values->values()->toArray(\net\dryuf\core\Dryuf::allocArray(null, $values->size())));
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a dynamic update statement, returning the number of rows affected
	 * 
	 * @param connection
	 * 	the connection
	 * @param table
	 * 	table name
	 * @param values
	 * 	map of column to value
	 * @param key
	 * 	map of column to value
	 * 
	 * @return
	 * 	the number of rows affected
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		runUpdate($connection, $table, $values, $key)
	{
		try {
			$binds = new \net\dryuf\util\LinkedList();
			$sb = (new \net\dryuf\core\StringBuilder("UPDATE "))->append($table)->append(" SET ");
			foreach ($values->entrySet() as $entry) {
				$sb->append($entry->getKey())->append(" = ?, ");
				$binds->add($entry->getValue());
			}
			$sb->replace($sb->length()-2, $sb->length(), " WHERE ");
			foreach ($key->entrySet() as $entry) {
				$sb->append($entry->getKey())->append(" = ? AND ");
				$binds->add($entry->getValue());
			}
			$sb->replace($sb->length()-5, $sb->length(), "");
			$st = $connection->prepareStatement(strval($sb));
			\net\dryuf\sql\SqlHelper::bindParams($st, $binds->toArray());
			return $st->executeUpdate();
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Runs a dynamic update statement or inserts the record if now row was affected.
	 * 
	 * @param connection
	 * 	the connection
	 * @param table
	 * 	table name
	 * @param values
	 * 	map of column to value
	 * @param key
	 * 	map of column to value
	 * 
	 * @return
	 * 	the number of rows affected
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		runUpdateInsert($connection, $table, $values, $key)
	{
		try {
			if (($affected = \net\dryuf\sql\SqlHelper::runUpdate($connection, $table, $values, $key)) != 0)
				return $affected;
			$binds = new \net\dryuf\util\LinkedList();
			$sb = (new \net\dryuf\core\StringBuilder("INSERT INTO "))->append($table)->append(" (");
			foreach ($values->entrySet() as $entry) {
				$sb->append($entry->getKey())->append(", ");
				$binds->add($entry->getValue());
			}
			foreach ($key->entrySet() as $entry) {
				$sb->append($entry->getKey())->append(", ");
				$binds->add($entry->getValue());
			}
			$sb->replace($sb->length()-2, $sb->length(), ") VALUES (");
			foreach ($binds as $bind) {
				$sb->append("?, ");
			}
			$sb->replace($sb->length()-2, $sb->length(), ")");
			return \net\dryuf\sql\SqlHelper::executeUpdateAny($connection->prepareStatement(strval($sb)), $binds->toArray());
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a dynamic delete statement, returning the number of rows affected
	 * 
	 * @param connection
	 * 	the connection
	 * @param table
	 * 	table name
	 * @param key
	 * 	hash list of column to value
	 * 
	 * @return
	 * 	the number of rows affected
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		runDelete($connection, $table, $key)
	{
		try {
			$sb = (new \net\dryuf\core\StringBuilder("DELETE FROM "))->append($table)->append(" WHERE ");
			foreach ($key->entrySet() as $entry) {
				$sb->append($entry->getKey())->append(" = ? AND ");
			}
			$sb->replace($sb->length()-2, $sb->length(), "");
			return \net\dryuf\sql\SqlHelper::executeUpdateAny($connection->prepareStatement(strval($sb)), $key->values()->toArray(\net\dryuf\core\Dryuf::allocArray(null, $key->size())));
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a dynamic select statement, returning list of rows as associative arrays
	 * 
	 * @param connection
	 * 	the connection
	 * @param columns
	 * 	the required columns
	 * @param table
	 * 	table name
	 * @param filter
	 * 	list of column to value pairs
	 * 
	 * @return
	 * 	the list of rows as associative arrays
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\util\Map<java\lang\String, java\lang\Object>>')
	*/
	public static function		runQuery($connection, $columns, $table, $filter)
	{
		try {
			$sb = new \net\dryuf\core\StringBuilder("SELECT ");
			foreach ($columns as $column) {
				$sb->append($column)->append(", ");
			}
			$sb->replace($sb->length()-2, $sb->length(), " FROM ")->append($table)->append(" ");
			foreach ($filter->entrySet() as $entry) {
				$sb->append($entry->getKey())->append(" = ? AND ");
			}
			$sb->replace($sb->length()-5, $sb->length(), "");
			$st = $connection->prepareStatement(strval($sb));
			return \net\dryuf\sql\SqlHelper::executeRows($st, $filter->values()->toArray(\net\dryuf\core\Dryuf::allocArray(null, $filter->size())));
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * runs a dynamic select statement, returning the value of the requested field
	 * 
	 * @param connection
	 * 	the connection
	 * @param field
	 * 	the required field
	 * @param table
	 * 	table name
	 * @param filter_name
	 * 	name of column to be filtered
	 * @param filter_value
	 * 	value of column to be filtered
	 * 
	 * @return null
	 * 	if no row was found
	 * @return field value
	 * 	if the entry was found
	 * 
	 * @note
	 * 	Throws an exception if more than one row is found
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		runField($connection, $field, $table, $filter_name, $filter_value)
	{
		try {
			$s = "SELECT ".$field." FROM ".$table." WHERE ".$filter_name." = ?";
			$st = $connection->prepareStatement($s);
			$st->bindParams(array($filter_value));
			$rs = $st->executeQuery();
			if ($rs->next()) {
				$value = $rs->getObject(1);
				if ($rs->next())
					throw new \javax\persistence\NonUniqueResultException("query returned more rows");
				return $value;
			}
			return null;
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Reads the last insert id from the statement.
	 * 
	 * @param statement
	 * 	the statement
	 * 
	 * @return
	 * 	the last insert id
	 * 
	 * @note
	 * 	Throws an exception in case retrieval failed
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public static function		getInsertId($statement)
	{
		try {
			return $statement->getInsertId();
		}
		catch (\net\dryuf\sql\SqlException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	 * Fetches single row from result set into map.
	 * 
	 * @param rs
	 * 	result set
	 * 
	 * @return null
	 * 	if no row was found
	 * @return row map
	 * 	if row was fetched
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public static function		fetchMap($rs)
	{
		try {
			if (!$rs->next())
				return null;
			return \net\dryuf\sql\SqlHelper::buildMap($rs);
		}
		catch (\net\dryuf\sql\SqlException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	 * Binds parameters to statement.
	 * 
	 * @param statement
	 * 	statement to bind
	 * @param binds
	 * 	binds to be bound
	 * 
	 * @return
	 * 	original statement
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\sql\PreparedStatement')
	*/
	protected static function	bindParams($statement, $binds)
	{
		$statement->bindParams($binds);
		return $statement;
	}

	/**
	 * Builds map from current row.
	 * 
	 * @param rs
	 * 	result set
	 * 
	 * @return
	 * 	map of current row
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected static function	buildMap($rs)
	{
		return $rs->getMapped();
	}
};


?>
