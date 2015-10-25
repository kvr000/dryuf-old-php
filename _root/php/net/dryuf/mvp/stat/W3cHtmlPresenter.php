<?php

namespace net\dryuf\mvp\stat;


class W3cHtmlPresenter extends \net\dryuf\mvp\stat\W3cXhtmlPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		try {
			$this->outputFormat("<a href=\"http://validator.w3.org/check?uri=%S;doctype=Inline\"><img border=\"0\" src=\"http://www.w3.org/Icons/valid-html401-%s\" alt=\"Valid HTML 4.01!\" height=\"31\" width=\"88\" /></a>", urlencode($this->getRootPresenter()->getFullUrl()), $this->w3cColor);
		}
		catch (\java\io\UnsupportedEncodingException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}
};


?>
