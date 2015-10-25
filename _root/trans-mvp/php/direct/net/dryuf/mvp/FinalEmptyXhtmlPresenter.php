<?php

namespace net\dryuf\mvp;


/**
 * Final presenter implementation which automatically registers itself as a main presenter+
 */
class FinalEmptyXhtmlPresenter extends \net\dryuf\mvp\EmptyXhtmlPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
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
