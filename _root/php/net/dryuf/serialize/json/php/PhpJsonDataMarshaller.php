<?php

namespace net\dryuf\serialize\json\php;


class PhpJsonDataMarshaller extends \net\dryuf\core\Object implements \net\dryuf\serialize\DataMarshaller
{
	/**
	*/
	public function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getMimeType()
	{
		return "application/json";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\OutputStream')
	*/
	public function			marshal($stream, $object)
	{
		fputs($stream, json_encode($this->convertStructuresToNative($object)));
		return $stream;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			unmarshal($stream, $clazz)
	{
		$content = stream_get_contents($stream);
		$value = json_decode($content, false);
		return $this->convertNativeToStructures($value, $clazz);
	}

	protected function		convertStructuresToNative($obj)
	{
		if ($obj instanceof \net\dryuf\util\Map) {
			$std = new \stdClass();
			foreach ($obj->entrySet() as $entry) {
				$key = $entry->getKey();
				$value = $entry->getValue();
				$std->$key = $value;
			}
			$obj = $std;
		}
		elseif ($obj instanceof \net\dryuf\util\Collection) {
			$obj = $obj->toArray();
		}
		if (is_array($obj) || $obj instanceof \stdClass) {
			foreach ($obj as &$e) {
				$e = $this->convertStructuresToNative($e);
			}
		}
		return $obj;
	}

	protected function		convertNativeToStructures($obj, $clazz)
	{
		if (is_null($obj))
			return null;
		if (gettype($obj) == "array") {
			if (is_null($clazz))
				$clazz = 'net\dryuf\util\Listable';
			foreach ($obj as &$e)
				$e = $this->convertNativeToStructures($e, null);
		}
		elseif ($obj instanceof \stdClass) {
			if (is_null($clazz))
				$clazz = 'net\dryuf\util\Map';
			foreach ($obj as &$e)
				$e = $this->convertNativeToStructures($e, null);
		}
		if (is_null($clazz))
			return $obj;
		switch ($clazz) {
		case 'net.dryuf.util.Set':
		case 'net\dryuf\util\Set':
			if (gettype($obj) != "array")
				throw new \net\dryuf\core\RuntimeException("cannot convert ".gettype($obj)." to ".$clazz);
			$obj = \net\dryuf\util\HashSet::createFromArray($obj);
			break;

		case 'net.dryuf.util.Collection':
		case 'net\dryuf\util\Collection':
		case 'net.dryuf.util.Listable':
		case 'net\dryuf\util\Listable':
			if (gettype($obj) != "array")
				throw new \net\dryuf\core\RuntimeException("cannot convert ".gettype($obj)." to ".$clazz);
			$obj = \net\dryuf\util\LinkedList::createFromArray($obj);
			break;

		case 'net.dryuf.util.Map':
		case 'net\dryuf\util\Map':
			if (!($obj instanceof \stdClass))
				throw new \net\dryuf\core\RuntimeException("cannot convert ".gettype($obj)." to ".$clazz);
			$old = $obj;
			$obj = new \net\dryuf\util\php\NativeHashMap();
			foreach ($old as $k => $v)
				$obj->put($k, $v);
			break;

		case 'bool':
		case 'boolean':
		case 'java.lang.Boolean':
		case 'java\lang\Boolean':
			$obj = boolval($obj);
			break;

		case 'byte':
		case 'java.lang.Byte':
		case 'java\lang\Byte':
		case 'short':
		case 'java.lang.Short':
		case 'java\lang\Short':
		case 'int':
		case 'integer':
		case 'java.lang.Integer':
		case 'java\lang\Integer':
			$obj = intval($obj);
			break;

		case 'float':
		case 'double':
		case 'java.lang.Float':
		case 'java\lang\Float':
		case 'java.lang.Double':
		case 'java\lang\Double':
			$obj = floatval($obj);
			break;

		case 'java.lang.String':
		case 'java\lang\String':
			$obj = strval($obj);
			break;

		default:
			if (substr($clazz, 0, 1) != '[')
				throw new \net\dryuf\core\RuntimeException("failed to convert ".gettype($obj)." to ".$clazz);
		}
		return $obj;
	}
};


?>
