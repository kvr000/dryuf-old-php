<?php

namespace net\dryuf\dao;


class RoleQuery extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->columns = new \net\dryuf\core\StringBuilder();
		$this->table = new \net\dryuf\core\StringBuilder();
		$this->where = new \net\dryuf\core\StringBuilder();
		$this->sort = new \net\dryuf\core\StringBuilder();
		$this->whereBinds = new \net\dryuf\util\LinkedList();
		$this->columnsBinds = new \net\dryuf\util\LinkedList();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setColumns($columns)
	{
		$this->columns = new \net\dryuf\core\StringBuilder($columns);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTable($table)
	{
		$this->table = new \net\dryuf\core\StringBuilder($table);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setWhere($where)
	{
		$this->where = new \net\dryuf\core\StringBuilder($where);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSort($sort)
	{
		$this->sort = new \net\dryuf\core\StringBuilder($sort);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendColumn($columnDef)
	{
		$this->columns->append(", ")->append($columnDef);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendColumns($columnDefs)
	{
		foreach ($columnDefs as $columnDef)
			$this->columns->append(", ")->append($columnDef);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendTable($tableName)
	{
		$this->table->append($tableName);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendWhere($condition)
	{
		$this->where->append($condition);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendSort($sort)
	{
		$this->sort->append($sort);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendWhereBinds($bindValues)
	{
		$this->whereBinds->addAll($bindValues);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendWhereBind($bindValue)
	{
		$this->whereBinds->add($bindValue);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendColumnsBinds($bindValues)
	{
		$this->columnsBinds->addAll($bindValues);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			appendColumnsBind($bindValue)
	{
		$this->columnsBinds->add($bindValue);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			createQuery()
	{
		return $this->columns." ".$this->table." ".$this->where;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Object>')
	*/
	public function			getWhereBinds()
	{
		return $this->whereBinds;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Object>')
	*/
	public function			getBinds()
	{
		$this->columnsBinds->addAll($this->whereBinds);
		return $this->columnsBinds;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	protected			$columns;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	public function			getColumns()
	{
		return $this->columns;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	protected			$table;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	public function			getTable()
	{
		return $this->table;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	protected			$where;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	public function			getWhere()
	{
		return $this->where;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	protected			$sort;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\StringBuilder')
	*/
	public function			getSort()
	{
		return $this->sort;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedList<java\lang\Object>')
	*/
	protected			$columnsBinds;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedList<java\lang\Object>')
	*/
	protected			$whereBinds;
};


?>
