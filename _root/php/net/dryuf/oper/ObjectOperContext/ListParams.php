<?php

namespace net\dryuf\oper\ObjectOperContext;


class ListParams extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getOffset()
	{
		return $this->offset;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setOffset($offset)
	{
		$this->offset = $offset;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getLimit()
	{
		return $this->limit;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLimit($limit)
	{
		$this->limit = $limit;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getFilters()
	{
		return $this->filters;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setFilters($filters)
	{
		$this->filters = $filters;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	public function			getSorts()
	{
		return $this->sorts;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSorts($sorts)
	{
		$this->sorts = $sorts;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	protected			$offset = null;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	protected			$limit = null;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$filters;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	protected			$sorts;
};


?>
