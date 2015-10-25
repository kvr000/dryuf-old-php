<?php

namespace net\dryuf\mvp\proc;


class MetaExportPresenter extends \net\dryuf\mvp\proc\XmlCachedExport
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
	public function			prepareData($file, $modinfo)
	{
		if (is_null(($match = \net\dryuf\core\StringUtil::matchText("^((\\w+\\.)*\\w+)/\$", $file))))
			throw new \net\dryuf\core\ReportException("invalid object name: ".$file);
		$file = $match[1];
		$viewName = \net\dryuf\core\Dryuf::defvalue($this->getRequest()->getParam("view"), "Default");
		if (is_null(\net\dryuf\core\StringUtil::matchText("^\\w+\$", $viewName)))
			throw new \net\dryuf\core\ReportException("invalid object name: ".$file);
		return $this->getCached($viewName, $file, "xml", $modinfo);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	public function			buildData($viewName, $className, $ext)
	{
		try {
			$clazz = $className;
		}
		catch (\net\dryuf\core\ClassNotFoundException $e) {
			return null;
		}
		return \net\dryuf\io\IoUtil::openMemoryStream(\net\dryuf\oper\MetaExport::buildMeta($this->getCallerContext(), $clazz, $viewName, $this->getRootPresenter()->getContextPath()."/_oper/".$className."/"));
	}
};


?>
