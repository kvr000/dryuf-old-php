<?php

namespace net\dryuf\xml\util;


class DomUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		convertNative($value, $defaultValue)
	{
		$valueClass = get_class($defaultValue);
		if (is_string($defaultValue))
			return $value;
		if (is_bool($defaultValue))
			return \net\dryuf\core\Dryuf::convertBool(($value === "true") || ($value === "1"));
		return \net\dryuf\core\Dryuf::invokeMethod(null, \net\dryuf\core\Dryuf::getClassMethod($valueClass, "valueOf", 'string'), $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public static function		getOptionalElement($parentElement, $elementName)
	{
		$nodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($parentElement, $elementName);
		if ($nodes->length != 1) {
			if ($nodes->length == 0)
				return null;
			throw new \net\dryuf\core\RuntimeException("expected single element on node ".$parentElement->nodeName);
		}
		return $nodes->item(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public static function		getSingleElement($parentElement, $elementName)
	{
		$nodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($parentElement, $elementName);
		if ($nodes->length != 1)
			throw new \net\dryuf\core\RuntimeException("expected single element on node ".$parentElement->nodeName);
		return $nodes->item(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public static function		getPreviousSameSibling($currentElement)
	{
		$name = $currentElement->nodeName;
		for ($previous = $currentElement->previousSibling; !is_null($previous) && ($previous->nodeType != XML_ELEMENT_NODE || !($name === $previous->nodeName)); $previous = $previous->previousSibling) ;
		return $previous;
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public static function		getNextSameSibling($currentElement)
	{
		$name = $currentElement->nodeName;
		for ($next = $currentElement->nextSibling; !is_null($next) && ($next->nodeType != XML_ELEMENT_NODE || !($name === $next->nodeName)); $next = $next->nextSibling) ;
		return $next;
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\NodeList')
	*/
	public static function		getImmediateElementsByTagName($parentElement, $elementName)
	{
		$found = new \net\dryuf\xml\util\DomUtil\NodeListImpl();
		for ($child = $parentElement->firstChild; !is_null($child); $child = $child->nextSibling) {
			if ($child->nodeType == XML_ELEMENT_NODE && ($child->nodeName === $elementName)) {
				$found->add($child);
			}
		}
		return $found->finish();
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public static function		getFirstElementByName($parentElement, $elementName)
	{
		$nodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($parentElement, $elementName);
		if ($nodes->length == 0)
			return null;
		return $nodes->item(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'org\w3c\dom\Element')
	*/
	public static function		getLastElementByName($parentElement, $elementName)
	{
		$nodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($parentElement, $elementName);
		if ($nodes->length == 0)
			return null;
		return $nodes->item($nodes->length-1);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getAttributeDefault($parentElement, $attributeName, $defaultValue)
	{
		$value = $parentElement->getAttribute($attributeName);
		if ((($value) == null)) {
			return $defaultValue;
		}
		if (is_null($defaultValue))
			return $value;
		return \net\dryuf\xml\util\DomUtil::convertNative($value, $defaultValue);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		getAttributeMandatory($parentElement, $attributeName)
	{
		$value = $parentElement->getAttribute($attributeName);
		if ((($value) == null)) {
			throw new \net\dryuf\core\RuntimeException("mandatory attribute ".$attributeName." not found on ".$parentElement->nodeName);
		}
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getSubElementContentDefault($parentElement, $elementName, $defaultValue)
	{
		$nodes = \net\dryuf\xml\util\DomUtil::getImmediateElementsByTagName($parentElement, $elementName);
		if ($nodes->length == 0)
			return $defaultValue;
		if ($nodes->length > 1)
			throw new \net\dryuf\core\RuntimeException("expected at most one element ".$elementName." on node ".$parentElement->nodeName);
		$value = $nodes->item(0)->textContent;
		return is_null($defaultValue) ? $value : \net\dryuf\xml\util\DomUtil::convertNative($value, $defaultValue);
	}
};


?>
