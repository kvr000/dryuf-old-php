<?php

namespace net\dryuf\xml\util\DomUtil;


class NodeListImpl extends \net\dryuf\core\Object implements \org\w3c\dom\NodeList
{
	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Node')
	*/
	public function			item($index)
	{
		return $this->items[$index];
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLength()
	{
		return count($this->items);
	}

	public				$length;

	/**
	*/
	function			__construct($list = null)
	{
		parent::__construct();
		$this->items = $list ? $list->toArray() : array();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			add($node)
	{
		array_push($this->items, $node);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\util\DomUtil\NodeListImpl')
	*/
	public function			finish()
	{
		$this->length = $this->getLength();
		return $this;
	}

	protected			$items;
};


?>
