<?php

namespace net\dryuf\mvp;


class TextRootPresenter extends \net\dryuf\mvp\CommonRootPresenter
{
	/**
	*/
	function			__construct($callerContext_, $request_)
	{
		parent::__construct($callerContext_, $request_);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			output($text)
	{
		fputs(STDOUT, $text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			escapeText($text)
	{
		return $text;
	}
};


?>
