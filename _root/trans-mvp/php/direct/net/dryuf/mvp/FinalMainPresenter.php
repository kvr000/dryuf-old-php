<?php

namespace net\dryuf\mvp;


/**
 * Final presenter implementation which automatically registers itself as a main presenter.
 */
class FinalMainPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter_, $options)
	{
		parent::__construct($parentPresenter_, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		$this->getRootPresenter()->setLeadChild($this);
		return parent::processFinal();
	}
};


?>
