<?php

namespace net\dryuf\mvp\proc;


class SessionPresenter extends \net\dryuf\mvp\FinalEmptyXhtmlPresenter
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
	public function			renderContent()
	{
		$session = $this->getRootPresenter()->getSession();
		if (is_null($session)) {
			$this->output("<p/>No session at all.");
			return;
		}
		$this->output("<p/>Session info:\n");
		$this->output("<table border='1'>\n");
		$this->renderRow("sid", $this->getRootPresenter()->getSession()->getSessionId());
		$this->renderRow("roles", \net\dryuf\core\StringUtil::join(", ", $this->getCallerContext()->getRoles()));
		$this->output("</table>\n");
		if ($this->getCallerContext()->checkRole("devel")) {
			$this->output("<p/>Session content:");
			$this->output("<table border='1'>\n");
			foreach ($session->getAllAttributes()->entrySet() as $entry) {
				$this->outputFormat("<tr><td>%S</td><td>%S</td></tr>\n", $entry->getKey(), var_export($entry->getValue(), 1));
			}
			$this->output("</table>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderRow($key, $value)
	{
		$this->outputFormat("<tr><td>%S</td><td>%S</td></tr>\n", $key, \net\dryuf\core\Dryuf::defvalue($value, "null"));
	}
};


?>
