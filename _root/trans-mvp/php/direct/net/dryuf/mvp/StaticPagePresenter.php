<?php

namespace net\dryuf\mvp;


class StaticPagePresenter extends \net\dryuf\mvp\GenericPageCodePresenter
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
		$this->output($this->getUiContext()->readLocalizedFile($this->page.".html"));
	}
};


?>
