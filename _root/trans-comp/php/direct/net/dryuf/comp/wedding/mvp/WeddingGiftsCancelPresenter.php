<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsCancelPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options->cloneAddingListed("formClass", "net.dryuf.wedding.WeddingGiftsCancelForm"));
		$this->giftPresenter = $parentPresenter;
		$this->weddingGiftsGiftDao = $this->giftPresenter->getWeddingGiftsGiftDao();
		$this->weddingGiftsHeader = $this->giftPresenter->getWeddingGiftsHeader();
		$this->giftPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_CANCEL);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\form\WeddingGiftsCancelForm')
	*/
	protected function		createBackingObject()
	{
		return new \net\dryuf\comp\wedding\form\WeddingGiftsCancelForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performCancel($action)
	{
		$cancelForm = $this->getBackingObject();
		if (!$this->weddingGiftsGiftDao->revertReservedCode($this->weddingGiftsHeader->getWeddingGiftsId(), $this->giftPresenter->getGift()->getDisplayName(), $cancelForm->getReservedCode())) {
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, 'net\dryuf\comp\wedding\mvp\WeddingGiftsCancelPresenter', "Your gift reservation cancellation failed, probably wrong code specified");
			return true;
		}
		else {
			$this->confirmed = true;
			$this->giftPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_CANCEL_DONE);
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\comp\wedding\mvp\WeddingGiftsCancelPresenter', "Your gift reservation has been successfully cancelled :-(");
			return true;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if ($this->confirmed) {
			$this->output($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsCancelPresenter', "Please go back to <a href=\"..\">wedding gifts list</a> and reserve different one :-)"));
		}
		else {
			parent::render();
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
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsHeader')
	*/
	protected			$weddingGiftsHeader;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$confirmed = false;
};


?>
