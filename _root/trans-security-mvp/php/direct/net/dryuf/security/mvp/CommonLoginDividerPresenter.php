<?php

namespace net\dryuf\security\mvp;


class CommonLoginDividerPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct(\net\dryuf\mvp\Presenter $parentPresenter_, \net\dryuf\core\Options $options)
	{
		parent::__construct($parentPresenter_, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		return self::$divider->processConsumed($this, $element);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		$this->isFinal = true;
		return self::$divider->processConsumed($this, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		parent::render();
		if ($this->isFinal) {
			$this->outputFormat("<a href=\"forgotpassword/\">%W</a><br/>", 'net\dryuf\security\mvp\CommonLoginDividerPresenter', "Forgot password?");
			$this->outputFormat("<a href=\"register/\">%W %W</a><br/>", 'net\dryuf\security\mvp\CommonLoginDividerPresenter', "Not registered yet?", 'net\dryuf\security\mvp\CommonLoginDividerPresenter', "Register now.");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isFinal = false;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	static				$divider;

	public static function		_initManualStatic()
	{
		self::$divider = (new \net\dryuf\mvp\StaticPresenterDivider(
			array(
				\net\dryuf\mvp\PresenterElement::createFunction("", true, "guest", 
					function ($parent) {
						return new \net\dryuf\security\mvp\CommonLoginPresenter($parent, \net\dryuf\core\Options::$NONE);
					}
				),
				\net\dryuf\mvp\PresenterElement::createClassed("register", true, "guest", 'net\dryuf\security\mvp\CommonRegisterPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("registerok", true, "guest", 'net\dryuf\security\mvp\RegisterOkPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("registeractivate", true, "guest", 'net\dryuf\security\mvp\CommonRegisterActivatePresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("forgotpassword", true, "guest", 'net\dryuf\security\mvp\CommonForgotPasswordPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("forgotupdatepassword", true, "guest", 'net\dryuf\security\mvp\CommonForgotUpdatePasswordPresenter', \net\dryuf\core\Options::$NONE)
			)))->setPageLocalizeClass('net\dryuf\security\mvp\CommonLoginDividerPresenter');
	}

};

\net\dryuf\security\mvp\CommonLoginDividerPresenter::_initManualStatic();


?>
