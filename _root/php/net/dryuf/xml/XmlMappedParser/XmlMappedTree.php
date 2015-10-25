<?php

namespace net\dryuf\xml\XmlMappedParser;


class XmlMappedTree extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($startHandler, $endHandler, $moresubs = null)
	{
		parent::__construct();
		$this->startHandler = $startHandler;
		$this->endHandler = $endHandler;
		if (count($moresubs) == 0) {
			$this->subtree = \net\dryuf\xml\XmlMappedParser::$EMPTY_TREE;
		}
		elseif ($moresubs[0] instanceof \net\dryuf\util\Map) {
			$this->subtree = $moresubs[0];
		}
		else {
			$this->subtree = new \net\dryuf\util\php\StringNativeHashMap();
			for ($i = 0; $i < count($moresubs); $i += 2) {
				$this->subtree->put($moresubs[$i], $moresubs[$i+1]);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlMappedTree')
	*/
	public static function		create($clazz, $startHandler, $endHandler)
	{
		$args = func_get_args();
		array_splice($args, 0, 3);
		return new \net\dryuf\xml\XmlMappedParser\XmlMappedTree(!is_null($startHandler) ? array($clazz, $startHandler) : null, !is_null($endHandler) ? array($clazz, $endHandler) : null, $args);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getStartHandler()
	{
		return $this->startHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$startHandler;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getEndHandler()
	{
		return $this->endHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$endHandler;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\xml\XmlMappedParser\XmlMappedTree>')
	*/
	public function			getSubtree()
	{
		return $this->subtree;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\xml\XmlMappedParser\XmlMappedTree>')
	*/
	protected			$subtree = null;
};


?>
