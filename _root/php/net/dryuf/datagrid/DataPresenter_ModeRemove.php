<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeRemove extends \net\dryuf\datagrid\DataPresenter_ModeSingle
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		\net\dryuf\datagrid\DataPresenter_ModeRemove::createSubPresenter('net\dryuf\mvp\jsuse\dryuf\DryufJsRegister', $this, \net\dryuf\core\Options::$NONE)->prepare();
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<div id=\"net-dryuf-datagrid-DataPresenter-remove\">\n<script type=\"text/javascript\">\nnet.dryuf.requireAsync(function() {\n\t\tnew net.dryuf.datagrid.DataGridPresenter(\n\t\t\tnull,\n\t\t\tdocument.getElementById(\"net-dryuf-datagrid-DataPresenter-remove\"),\n\t\t\t{\n\t\t\t\tdataClassName:\t\t%J,\n\t\t\t\tmode:\t\t\t'remove',\n\t\t\t\tobjKey:\t\t\t%s,\n\t\t\t\trpcPath:\t\t%J,\n\t\t\t\tmanager:\t\tnew net.dryuf.datagrid.DataGridRedirManager(null, null, { redirTarget: \"%s\", }),\n\t\t\t}\n\t\t);\n\t},\n\t'net.dryuf.datagrid.DataGridRedirManager',\n\t'net.dryuf.datagrid.DataGridPresenter');\n</script>\n</div>\n", $this->getDataPresenter()->getDataClass(), \net\dryuf\text\JsonCodec::encode($this->classMeta->getEntityPkValue($this->currentObject->getEntity())), "../-oper-/", \net\dryuf\core\StringUtil::defaultIfEmpty($this->getDataPresenter()->getRelativeUrl(), "./"));
	}
};


?>
