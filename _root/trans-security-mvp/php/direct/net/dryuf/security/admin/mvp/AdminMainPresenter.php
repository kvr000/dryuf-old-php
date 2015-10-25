<?php

namespace net\dryuf\security\admin\mvp;


class AdminMainPresenter extends \net\dryuf\mvp\ChildPresenter
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
	public function			render()
	{
		$this->output("<ul>\n");
		$this->outputFormat("<li><a href=\"translation/\">%W</a></li>", 'net\dryuf\security\admin\mvp\AdminMainPresenter', "Translation");
		$this->outputFormat("<li><a href=\"roles/\">%W</a></li>", 'net\dryuf\security\admin\mvp\AdminMainPresenter', "Roles");
		$this->output("</ul>\n");
		$this->outputFormat("<p>Your roles: %S</p>\n", \net\dryuf\core\StringUtil::join(", ", $this->getCallerContext()->getRoles()));
	}
};


?>
