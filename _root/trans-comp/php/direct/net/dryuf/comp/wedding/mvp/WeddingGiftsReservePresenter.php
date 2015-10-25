<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsReservePresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options->cloneAddingListed("formClass", "net.dryuf.wedding.WeddingGiftsReserveForm"));
		$this->giftPresenter = $this->parentPresenter;
		$this->weddingGiftsGiftDao = $this->giftPresenter->getWeddingGiftsGiftDao();
		$this->giftPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_RESERVE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\form\WeddingGiftsReserveForm')
	*/
	protected function		createBackingObject()
	{
		return new \net\dryuf\comp\wedding\form\WeddingGiftsReserveForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			retrieve($errors, $action)
	{
		$reserveForm = $this->getBackingObject();
		if (!parent::retrieve($errors, $action))
			return false;
		if (!($reserveForm->getEmail() === $reserveForm->getEmailConfirm()))
			$errors->put("emailConfirm", $this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "E-mail doesn't match"));
		return $errors->isEmpty();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performReserve($action)
	{
		$reserveForm = $this->getBackingObject();
		$reservedCode = \net\dryuf\text\util\TextUtil::generateCode(8);
		if (!$this->weddingGiftsGiftDao->setReservedCode($this->giftPresenter->getWeddingGiftsHeader()->getWeddingGiftsId(), $this->giftPresenter->getGift()->getDisplayName(), $reservedCode)) {
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, 'net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Your has gift reservation failed, probably someone reserved in the meantime");
			return true;
		}
		else {
			$emailSender = $this->getCallerContext()->getBeanTyped("emailSender", 'net\dryuf\service\mail\EmailSender');
			$emailSender->mailUtf8($reserveForm->getEmail(), $this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Wedding Gift Reservation"), 
				$this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Your Gift has been successfully reserved.")."\n".$this->localizeArgs('net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Your reservation code is {0}.", 
					array(
						$reservedCode
					))."\n\n".$this->giftPresenter->getGift()->getName().":\n".$this->giftPresenter->getGift()->getDescription(), 
				$this->giftPresenter->getWeddingGiftsHeader()->getContactEmail());
			$this->confirmed = true;
			$this->giftPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_RESERVE_DONE);
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Your gift has been successfully reserved, we're looking forward to it :-)");
			$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Info, 
				$this->getUiContext()->localizeArgs('net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Your reservation code is {0}", 
					array(
						$reservedCode
					)));
			return true;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->confirmed) {
			$this->output($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "Please go back to <a href=\"..\">wedding gifts list</a> and reserve one more :-)"));
		}
		else {
			parent::render();
			$this->outputFormat("%W", 'net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', "We use your E-mail address only for sending the reservation code, we like surprise :-)");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\mvp\WeddingGiftsGiftPresenter')
	*/
	protected			$giftPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsGiftDao')
	*/
	protected			$weddingGiftsGiftDao;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$confirmed = false;
};


?>
