<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsCoordinatorPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->giftPresenter = $parentPresenter;
		$this->giftPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_COORDINATE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\form\WeddingGiftsCoordinatorForm')
	*/
	protected function		createBackingObject()
	{
		return new \net\dryuf\comp\wedding\form\WeddingGiftsCoordinatorForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performSubmit($action)
	{
		$coordinatorForm = $this->getBackingObject();
		$emailSender = $this->getCallerContext()->getBeanTyped("emailSender", 'net\dryuf\service\mail\EmailSender');
		$emailSender->mailUtf8($this->giftPresenter->weddingGiftsHeader->getCoordinatorEmail(), $this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsCoordinatorPresenter', "Wedding Gift Question"), $coordinatorForm->getYourEmail()." ".$this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsCoordinatorPresenter', "has a question regarding wedding gift:")."\n\n".$coordinatorForm->getDescription(), $coordinatorForm->getYourEmail());
		$this->confirmed = true;
		$this->giftPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_COORDINATE_DONE);
		$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\comp\wedding\mvp\WeddingGiftsCoordinatorPresenter', "Your question has been sent to our coordinator. Thank you!");
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->confirmed) {
			$this->output($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsCoordinatorPresenter', "Please go back to <a href=\".\">wedding gifts list</a>."));
		}
		else {
			parent::render();
			$this->outputFormat("%W", 'net\dryuf\comp\wedding\mvp\WeddingGiftsCoordinatorPresenter', "Your question will be sent to our coordinator and you will receive response to your e-mail.");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\mvp\WeddingGiftsGiftPresenter')
	*/
	protected			$giftPresenter;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$confirmed = false;
};


?>
