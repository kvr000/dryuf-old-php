<?php

namespace net\dryuf\mvp\stat;


class GoogleAnalyticsPresenter extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->gaSite = strval($options->getOptionMandatory("site"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<script type=\"text/javascript\">\nvar gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");\ndocument.write(unescape(\"%%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%%3E%%3C/script%%3E\"));\n</script>\n<script type=\"text/javascript\">\n\ttry {\n\t\tvar pageTracker = _gat._getTracker(\"%S\");\n\t\tpageTracker._trackPageview();\n\t}\n\tcatch(err) {}\n</script>\n", $this->gaSite);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$gaSite;
};


?>
