<?php

namespace net\dryuf\xml;


class XmlMappedParser extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->saxParser = xml_parser_create('UTF-8');
		xml_set_element_handler($this->saxParser, array($this, 'startMappedElement'), array($this, 'endMappedElement'));
		xml_set_character_data_handler($this->saxParser, array($this, 'characterData'));
		xml_parser_set_option($this->saxParser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($this->saxParser, XML_OPTION_CASE_FOLDING, 0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setupHandlers($handlerObject, $mainHandlers)
	{
		$this->dynamicObject = $handlerObject;
		$this->dynamicStack = new \net\dryuf\util\LinkedList();
		$this->dynamicStack->push($mainHandlers);
		throw new \RuntimeException("obsolete");
		//$this->saxHandler = new \org\xml\sax\helpers\DefaultHandler()
		//class  {
		//    
		//    public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {
		//        startDynamicElement(qName, attributes);
		//    }
		//    
		//    public void endElement(String uri, String localName, String qName) throws SAXException {
		//        endDynamicElement(qName);
		//    }
		//    
		//    public void characters(char[] ch, int start, int length) throws SAXException {
		//        characterData(new String(ch, start, length));
		//    }
		//};
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
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			processStream($inputStream)
	{
		try {
			if (!xml_parse($this->saxParser, stream_get_contents($inputStream), true))
				throw new \net\dryuf\core\Exception(xml_error_string(xml_get_error_code($this->saxParser)));
		}
		catch (\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("parsing xml failed at byte ".xml_get_current_byte_index($this->saxParser).": ".$ex->__toString(), $ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			processContent($content)
	{
		try {
			if (!xml_parse($this->saxParser, $inputStream, true))
				throw new \net\dryuf\core\Exception(xml_error_string(xml_get_error_code($this->saxParser)));
		}
		catch (\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("parsing xml failed at byte ".xml_get_current_byte_index($this->saxParser).": ".$ex->__toString(), $ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			processPartial($content)
	{
		try {
			if (!xml_parse($this->saxParser, $content, false))
				throw new \net\dryuf\core\Exception(xml_error_string(xml_get_error_code($this->saxParser)));
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\Exception("parsing xml failed at byte ".xml_get_current_byte_index($this->saxParser).": ".$ex->__toString(), $ex);
		}
	}


	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			startDynamicElement($tag, $attrList)
	{
		throw new \RuntimeException("unsupported");
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
		throw new \RuntimeException("unsupported");
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
	public function			startMappedElement($parser, $tag, $attrList)
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
			$this->mappedObject->{$current->getStartHandler()[1]}($tag, new \net\dryuf\xml\sax\AttributesLocal($attrList));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			endMappedElement($parser, $tag)
	{
		$current = $this->mappedStack->pop();
		$content = $this->textStack->pop();
		if (!is_null($current) && !is_null($current->getEndHandler())) {
			$this->mappedObject->{$current->getEndHandler()[1]}($tag, $content);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			characterData($parser, $data)
	{
		$this->textStack->push($this->textStack->pop().$data);
	}

	/**
	@\net\dryuf\core\Type(type = 'javax\xml\parsers\SAXParser')
	*/
	protected			$saxParser;

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
		self::$handlerDummy = new \net\dryuf\xml\XmlMappedParser\XmlDynamicHandler(null, array('net\dryuf\xml\XmlMappedParser', "startDummyElement"), array('net\dryuf\xml\XmlMappedParser', "endDummyElement"), array('net\dryuf\xml\XmlMappedParser', "childDummyElement"));
	}

};

\net\dryuf\xml\XmlMappedParser::_initManualStatic();


?>
