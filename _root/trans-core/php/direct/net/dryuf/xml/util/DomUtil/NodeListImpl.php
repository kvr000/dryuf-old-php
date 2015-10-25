<?php

namespace net\dryuf\xml\util\DomUtil;


class NodeListImpl extends \net\dryuf\core\Object implements \org\w3c\dom\NodeList
{
	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Node')
	*/
	public function			item($index)
	{
		return $this->items->get($index);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLength()
	{
		return $this->items->size();
	}

	/**
	*/
	function			__construct($list)
	{
		parent::__construct();
		$this->items = $list;
	}

	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->items = new \net\dryuf\util\LinkedList();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			add($node)
	{
		$this->items->add($node);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\util\DomUtil\NodeListImpl')
	*/
	public function			finish()
	{
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<org\w3c\dom\Node>')
	*/
	protected			$items;
};


?>
