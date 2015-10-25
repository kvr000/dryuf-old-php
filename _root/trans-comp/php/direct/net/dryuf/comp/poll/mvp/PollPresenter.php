<?php

namespace net\dryuf\comp\poll\mvp;


class PollPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $pollHandler)
	{
		parent::__construct($parentPresenter, $options);
		$this->urlPath = $options->getOptionMandatory("urlPath");
		$this->pollHandler = $pollHandler;
		$this->cssClass = \net\dryuf\core\Dryuf::dashClassname($options->getOptionDefault("cssClass", \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\poll\mvp\PollPresenter')));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if ($this->getCallerContext()->isLoggedIn())
			$this->pollHandler->addPollVote($this->getCallerContext()->getUserId(), \net\dryuf\core\Dryuf::parseInt($this->getRequest()->getParamMandatory("pollVote")));
		$this->getRootPresenter()->getResponse()->redirect("../");
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$canVote = $this->pollHandler->getCallerContext()->checkRole("Poll.vote");
		$detail = $this->pollHandler->getPollDetail();
		$this->outputFormat("<table class='net-dryuf-comp-poll-web-PollPresenter'>\n");
		$this->outputFormat("<tr class='header'><th colspan='3'>%S</th></tr>\n", $detail->getDescription());
		if (($totalVotes = $detail->getTotalVotes()) == 0)
			$totalVotes = 1;
		foreach ($this->pollHandler->getPollOptions() as $option) {
			$this->outputFormat("<tr><td class='option'>");
			if ($canVote) {
				$this->outputFormat("<a href=\"%S?pollVote=%S\">%S</a>", $this->urlPath, strval($option->getOptionId()), $option->getDescription());
			}
			else {
				$this->outputFormat("%S", $option->getDescription());
			}
			$this->outputFormat("</td><td class='barcolumn'><div class='bar' style='width: %S%%;'></div></td><td class='percent'>%S%%</td></tr>\n", strval(floor(intval(100*$option->getVoteCount()/$totalVotes))), strval(floor(intval(100*$option->getVoteCount()/$totalVotes))));
		}
		$this->outputFormat("<tr class='footer'><td colspan='2'>%W</td><td class='total'>%S</td></tr>\n", 'net\dryuf\comp\poll\mvp\PollPresenter', "Total votes", strval($detail->getTotalVotes()));
		if (!$canVote) {
			$this->outputFormat("<tr><td colspan='3'>");
			(new \net\dryuf\mvp\NeedLoginPresenter($this, \net\dryuf\mvp\NoLeadChildPresenter::$NOLEAD_OPTIONS->cloneAddingListed("messageClass", \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\poll\mvp\PollPresenter'), "message", "For polling you need to --login--.")))->render();
			$this->outputFormat("</td></tr>\n");
		}
		$this->outputFormat("</table>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$urlPath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$cssClass;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	protected			$pollHandler;
};


?>
