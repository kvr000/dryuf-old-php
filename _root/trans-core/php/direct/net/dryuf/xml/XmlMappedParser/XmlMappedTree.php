<?php

namespace net\dryuf\xml\XmlMappedParser;


class XmlMappedTree extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($startHandler, $endHandler, $subtree)
	{
		parent::__construct();
		$this->startHandler = $startHandler;
		$this->endHandler = $endHandler;
		$this->subtree = $subtree;
	}

	/**
	*/
	function			__construct($startHandler, $endHandler, $tag, $tagsub, $moresub)
	{
		parent::__construct();
		$this->startHandler = $startHandler;
		$this->endHandler = $endHandler;
		$this->subtree = new \net\dryuf\util\php\StringNativeHashMap();
		$this->subtree->put($tag, $tagsub);
		for ($i = 0; $i < count($moresub); $i += 2) {
			$this->subtree->put($moresub[$i], $moresub[$i+1]);
		}
	}

	/**
	*/
	function			__construct($startHandler, $endHandler)
	{
		parent::__construct();
		$this->startHandler = $startHandler;
		$this->endHandler = $endHandler;
		(=f_I_x= msg="java.lang.NoSuchFieldException: EMPTY_TREE")this.subtree = EMPTY_TREE;(=x_I_f=)
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlMappedTree')
	*/
	public static function		create($clazz, $startHandler, $endHandler)
	{
		return new \net\dryuf\xml\XmlMappedParser\XmlMappedTree(!is_null($startHandler) ? \net\dryuf\core\Dryuf::getClassMethod($clazz, $startHandler, 'string', 'org\xml\sax\Attributes') : null, !is_null($endHandler) ? \net\dryuf\core\Dryuf::getClassMethod($clazz, $endHandler, 'string', 'string') : null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlMappedTree')
	*/
	public static function		create($clazz, $startHandler, $endHandler, $subtree)
	{
		return new \net\dryuf\xml\XmlMappedParser\XmlMappedTree(!is_null($startHandler) ? \net\dryuf\core\Dryuf::getClassMethod($clazz, $startHandler, 'string', 'org\xml\sax\Attributes') : null, !is_null($endHandler) ? \net\dryuf\core\Dryuf::getClassMethod($clazz, $endHandler, 'string', 'string') : null, $subtree);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlMappedTree')
	*/
	public static function		create($clazz, $startHandler, $endHandler, $tag, $tagsub, $moresubs)
	{
		return new \net\dryuf\xml\XmlMappedParser\XmlMappedTree(!is_null($startHandler) ? \net\dryuf\core\Dryuf::getClassMethod($clazz, $startHandler, 'string', 'org\xml\sax\Attributes') : null, !is_null($endHandler) ? \net\dryuf\core\Dryuf::getClassMethod($clazz, $endHandler, 'string', 'string') : null, $tag, $tagsub, $moresubs);
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
