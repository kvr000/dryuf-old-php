<?php

namespace net\dryuf\security\textual;


class UserAccountTextual extends \net\dryuf\textual\NaturalLongTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Textual<java\lang\Long>')
	*/
	public function			setCallerContext($callerContext)
	{
		parent::setCallerContext($callerContext);
		$this->boUserAccount = $callerContext->getBean("userAccountBo");
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return $this->boUserAccount->loadUsername($internal);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	*/
	public				$boUserAccount;
};


?>
