<?php

namespace net\dryuf\xml;


class XmlMappedParser extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		try {
			$this->saxParser = \javax\xml\parsers\SAXParserFactory::newInstance()->newSAXParser();
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setupHandlers($handlerObject, $mainHandlers)
	{
		$this->dynamicObject = $handlerObject;
		$this->dynamicStack = new \net\dryuf\util\LinkedList();
		$this->dynamicStack->push($mainHandlers);
		$this->saxHandler = new \org\xml\sax\helpers\DefaultHandler()(=f_I_x=)
		class  {
		    
		    public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {
		        startDynamicElement(qName, attributes);
		    }
		    
		    public void endElement(String uri, String localName, String qName) throws SAXException {
		        endDynamicElement(qName);
		    }
		    
		    public void characters(char[] ch, int start, int length) throws SAXException {
		        characterData(new String(ch, start, length));
		    }
		}(=x_I_f=);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setupMapped($mappedObject, $handlingMap)
	{
		$this->mappedObject = $mappedObject;
		$this->mappedStack = new \net\dryuf\util\LinkedList();
		$this->mappedStack->push($handlingMap);
		$this->textStack = new \net\dryuf\util\LinkedList();
		$this->saxHandler = new \org\xml\sax\helpers\DefaultHandler()(=f_I_x=)
		class  {
		    
		    public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {
		        startMappedElement(qName, attributes);
		    }
		    
		    public void endElement(String uri, String localName, String qName) throws SAXException {
		        endMappedElement(qName);
		    }
		    
		    public void characters(char[] ch, int start, int length) throws SAXException {
		        characterData(new String(ch, start, length));
		    }
		}(=x_I_f=);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			processStream($inputStream)
	{
		try {
			$this->saxParser->parse($inputStream, $this->saxHandler);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			processContent($content)
	{
		$this->processStream(\net\dryuf\io\IoUtil::openMemoryStream($content));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			processPartial($content)
	{
		$this->processStream(\net\dryuf\io\IoUtil::openMemoryStream($content));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startDynamicElement($tag, $attrList)
	{
		$handler = $this->dynamicStack->peek();
		if (!is_null($handler->getChildHandler())) {
			if (is_null(($handler = \net\dryuf\core\Dryuf::invokeMethod(!is_null($handler->getHandlerObject()) ? $handler->getHandlerObject() : $this->dynamicObject, $handler->getChildHandler(), $tag, $attrList))))
				$handler = self::$handlerDummy;
			if (!is_null($handler->getStartHandler()))
				\net\dryuf\core\Dryuf::invokeMethod(!is_null($handler->getHandlerObject()) ? $handler->getHandlerObject() : $this->dynamicObject, $handler->getStartHandler(), $tag, $attrList);
		}
		$this->textStack->push("");
		$this->dynamicStack->push($handler);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endDynamicElement($tag)
	{
		$handler = $this->dynamicStack->pop();
		$content = $this->textStack->pop();
		if (!is_null($handler->getEndHandler())) {
			\net\dryuf\core\Dryuf::invokeMethod(!is_null($handler->getHandlerObject()) ? $handler->getHandlerObject() : $this->dynamicObject, $handler->getEndHandler(), $tag, $content);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		startDummyElement($tag, $attrList)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		endDummyElement($tag, $content)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlDynamicHandler')
	*/
	public static function		childDummyElement($tag, $attrList)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startMappedElement($tag, $attrList)
	{
		$current = $this->mappedStack->peek();
		if (!is_null($current)) {
			if ($current->getSubtree()->containsKey($tag)) {
				$current = $current->getSubtree()->get($tag);
			}
			elseif ($current->getSubtree()->containsKey("*")) {
				$current = $current->getSubtree()->get("*");
			}
			else {
				$current = null;
			}
		}
		$this->mappedStack->push($current);
		$this->textStack->push("");
		if (!is_null($current) && !is_null($current->getStartHandler())) {
			\net\dryuf\core\Dryuf::invokeMethod($this->mappedObject, $current->getStartHandler(), $tag, $attrList);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endMappedElement($tag)
	{
		$current = $this->mappedStack->pop();
		$content = $this->textStack->pop();
		if (!is_null($current) && !is_null($current->getEndHandler())) {
			\net\dryuf\core\Dryuf::invokeMethod($this->mappedObject, $current->getEndHandler(), $tag, $content);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			characterData($data)
	{
		$this->textStack->push($this->textStack->pop().$data);
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\xml\parsers\SAXParser')
	*/
	protected			$saxParser;

	/**
	@\net\dryuf\core\Type(type = 'org\xml\sax\helpers\DefaultHandler')
	*/
	protected			$saxHandler;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedList<java\lang\String>')
	*/
	protected			$textStack;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$dynamicObject;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedList<net\dryuf\xml\XmlMappedParser\XmlDynamicHandler>')
	*/
	protected			$dynamicStack;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$mappedObject;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedList<net\dryuf\xml\XmlMappedParser\XmlMappedTree>')
	*/
	protected			$mappedStack;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\xml\XmlMappedParser\XmlMappedTree>')
	*/
	static				$EMPTY_TREE;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\xml\XmlMappedParser\XmlDynamicHandler')
	*/
	static				$handlerDummy;

	public static function		_initManualStatic()
	{
		self::$EMPTY_TREE = new \net\dryuf\util\php\StringNativeHashMap();
		self::$handlerDummy = new \net\dryuf\xml\XmlMappedParser\XmlDynamicHandler(null, \net\dryuf\core\Dryuf::getClassMethod('net\dryuf\xml\XmlMappedParser', "startDummyElement", 'string', 'org\xml\sax\Attributes'), \net\dryuf\core\Dryuf::getClassMethod('net\dryuf\xml\XmlMappedParser', "endDummyElement", 'string', 'string'), \net\dryuf\core\Dryuf::getClassMethod('net\dryuf\xml\XmlMappedParser', "childDummyElement", 'string', 'org\xml\sax\Attributes'));
	}

};

\net\dryuf\xml\XmlMappedParser::_initManualStatic();


?>
