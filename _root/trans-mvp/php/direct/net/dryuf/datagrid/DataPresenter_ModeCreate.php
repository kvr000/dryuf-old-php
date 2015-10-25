<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeCreate extends \net\dryuf\datagrid\DataPresenter_SubMode
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
		\net\dryuf\datagrid\DataPresenter_ModeCreate::createSubPresenter('net\dryuf\mvp\jsuse\dryuf\DryufJsRegister', $this, \net\dryuf\core\Options::$NONE)->prepare();
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<div id=\"net-dryuf-datagrid-DataPresenter-new\">\n<script type=\"text/javascript\">\nnet.dryuf.requireAsync(function() {\n\t\tnew net.dryuf.datagrid.DataGridPresenter(\n\t\t\tnull,\n\t\t\tdocument.getElementById(\"net-dryuf-datagrid-DataPresenter-new\"),\n\t\t\t{\n\t\t\t\tdataClassName:\t\t%J,\n\t\t\t\tmode:\t\t\t'new',\n\t\t\t\trpcPath:\t\t%J,\n\t\t\t\tmanager:\t\tnew net.dryuf.datagrid.DataGridRedirManager(null, null, { redirTarget: \"../\", }),\n\t\t\t}\n\t\t);\n\t},\n\t'net.dryuf.datagrid.DataGridRedirManager',\n\t'net.dryuf.datagrid.DataGridPresenter');\n</script>\n</div>\n", $this->getDataPresenter()->getDataClass(), "../-oper-/");
	}
};


?>
