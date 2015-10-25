<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsProposePresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options->cloneAddingListed("formClass", "net.dryuf.wedding.WeddingGiftsProposeForm"));
		$this->giftsPresenter = $parentPresenter;
		$this->giftsPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_PROPOSE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\form\WeddingGiftsProposeForm')
	*/
	protected function		createBackingObject()
	{
		return new \net\dryuf\comp\wedding\form\WeddingGiftsProposeForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performPropose($action)
	{
		$proposeForm = $this->getBackingObject();
		$emailSender = $this->getCallerContext()->getBeanTyped("emailSender", 'net\dryuf\service\mail\EmailSender');
		$emailSender->mailUtf8($this->giftsPresenter->getWeddingGiftsHeader()->getProposalEmail(), $this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsProposePresenter', "Wedding Gift Proposal"), $proposeForm->getYourEmail()." ".$this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsProposePresenter', "gives a proposal for wedding gift:")."\n\n".$proposeForm->getDescription(), $proposeForm->getYourEmail());
		$this->confirmed = true;
		$this->parentPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_PROPOSE_DONE);
		$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\comp\wedding\mvp\WeddingGiftsProposePresenter', "Your proposal has been sent to our coordinator. Thank you!");
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->confirmed) {
			$this->output($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsProposePresenter', "Please go back to <a href=\".\">wedding gifts list</a>."));
		}
		else {
			parent::render();
			$this->outputFormat("%W", 'net\dryuf\comp\wedding\mvp\WeddingGiftsProposePresenter', "Your proposal will be sent to our coordinator and you will receive response to your e-mail.");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter')
	*/
	protected			$giftsPresenter;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$confirmed = false;
};


?>
