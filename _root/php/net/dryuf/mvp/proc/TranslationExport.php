<?php

namespace net\dryuf\mvp\proc;


class TranslationExport extends \net\dryuf\mvp\proc\JsonCachedExport
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			prepareData($file, $modified)
	{
		$classname = $file;
		if (is_null(($match = \net\dryuf\core\StringUtil::matchText("^((\\w+\\.)*\\w+)/\$", $classname)))) {
			throw new \net\dryuf\core\ReportException("invalid classname: ".$classname);
		}
		return $this->getCached("default", $match[1], "translation", $modified);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			buildData($subid, $classname, $ext)
	{
		$out = new \net\dryuf\core\StringBuilder("{");
		foreach ($this->getUiContext()->getClassLocalization($classname)->entrySet() as $entry) {
			$key = $entry->getKey();
			$value = $entry->getValue();
			$out->append("\"")->append(str_replace("\"", "\\\"", $key))->append("\":\"")->append(str_replace("\"", "\\\"", $value))->append("\",");
		}
		if ($out->length() > 1)
			$out->setLength($out->length()-1);
		$out->append("}");
		return \net\dryuf\io\IoUtil::openMemoryStream(strval($out));
	}
};


?>
