<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsListPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->giftsPresenter = $parentPresenter;
		$this->weddingGiftsHeaderDao = $this->giftsPresenter->getWeddingGiftsHeaderDao();
		$this->weddingGiftsGiftDao = $this->giftsPresenter->getWeddingGiftsGiftDao();
		$this->weddingGiftsHeader = $this->giftsPresenter->getWeddingGiftsHeader();
		$this->weddingGiftsId = $this->giftsPresenter->getWeddingGiftsId();
		$this->giftsPresenter->setMode(\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::MODE_LIST);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$gifts = new \net\dryuf\util\LinkedList();
		$this->weddingGiftsGiftDao->listDynamic($gifts, new \net\dryuf\core\EntityHolder($this->weddingGiftsHeader, $this->getCallerContext()), null, null, null, null);
		if (!is_null($this->weddingGiftsHeader->getCoordinatorEmail())) {
			$this->output("<p>");
			$this->output($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "In case of questions please contact our <a href=\"coordinator.html\">gift coordinator</a>."));
			$this->output("</p>");
		}
		$this->outputFormat("<table border=\"1\">\n<tr><th>%W</th><th>%W</th><th>%W</th><th>%W</th></tr>\n", 'net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "Inspiration", get_class($this), "Name", get_class($this), "Description", get_class($this), "State");
		foreach ($gifts as $holder) {
			$gift = $holder->getEntity();
			$this->outputFormat("<tr><td><img width='198' src=%A /></td><td>%S</td><td>%S</td><td>", $gift->getInspirationUrl(), $gift->getName(), $gift->getDescription());
			if (is_null($gift->getReservedCode())) {
				$this->outputFormat("%s, <a href=\"%s/reserve.html\">%s</a>", htmlspecialchars($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "Available")), htmlspecialchars(\net\dryuf\net\util\UrlUtil::encodeUrl($gift->getDisplayName())), htmlspecialchars($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "Reserve")));
			}
			else {
				$this->outputFormat("%s, <a href=\"%s/cancel.html\">%s</a>", htmlspecialchars($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "Reserved")), htmlspecialchars(\net\dryuf\net\util\UrlUtil::encodeUrl($gift->getDisplayName())), htmlspecialchars($this->localize('net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "Cancel")));
			}
			$this->output("</td></tr>\n");
		}
		if (!is_null($this->weddingGiftsHeader->getProposalEmail())) {
			$this->outputFormat("<tr><td align='center'><b><font size=\"+5\">?</font></b></td><td>%W</td><td>%W</td><td><a href=\"propose.html\">%W</a></td></tr>\n", 'net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', "Proposal", get_class($this), "Proposal according to your ideas.", get_class($this), "Propose");
		}
		$this->output("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter')
	*/
	protected			$giftsPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsHeaderDao')
	*/
	protected			$weddingGiftsHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsGiftDao')
	*/
	protected			$weddingGiftsGiftDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsHeader')
	*/
	protected			$weddingGiftsHeader;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$weddingGiftsId = 0;
};


?>
