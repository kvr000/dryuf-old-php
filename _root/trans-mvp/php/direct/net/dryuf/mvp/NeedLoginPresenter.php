<?php

namespace net\dryuf\mvp;


class NeedLoginPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$messageObj = $options->getOptionDefault("messageClass", 'net\dryuf\mvp\NeedLoginPresenter');
		$this->messageClass = is_string($messageObj) ? $messageObj : $messageObj;
		$this->message = $options->getOptionDefault("message", "You need to --login-- to continue.");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		parent::render();
		$this->message = htmlspecialchars($this->localize($this->messageClass, $this->message));
		if (!is_null(($split = \net\dryuf\core\StringUtil::matchText("^(.*)--(.*?)--(.*)\$", $this->message)))) {
			try {
				$this->message = $split[1]."<a href=\"".htmlspecialchars(\net\dryuf\net\util\UrlUtil::appendQuery($this->getRootPresenter()->stringifyRef(\net\dryuf\srvui\PageUrl::createPaged("login")), "redir=/".urlencode($this->getRootPresenter()->getCurrentPath())))."\">".$split[2]."</a>".$split[3];
			}
			catch (\java\io\UnsupportedEncodingException $e) {
				throw new \net\dryuf\core\RuntimeException($e);
			}
		}
		$this->output("<p>".$this->message."</p>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$message;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$messageClass;
};


?>
