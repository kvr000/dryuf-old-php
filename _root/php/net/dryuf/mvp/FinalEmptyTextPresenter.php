<?php

namespace net\dryuf\mvp;


/**
 * Final presenter implementation which automatically registers itself as a main presenter.
 * 
 * Sends text/plain as content type.
 */
class FinalEmptyTextPresenter extends \net\dryuf\mvp\FinalMainPresenter
{
	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		parent::__construct($parentPresenter_, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->getRootPresenter()->getResponse()->setContentType("text/plain; charset=UTF-8");
	}
};


?>
