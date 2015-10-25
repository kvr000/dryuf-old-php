<?php

namespace net\dryuf\srvui;


class LangRefStringifier extends \net\dryuf\core\Object implements \net\dryuf\srvui\RefStringifier
{
	/**
	*/
	function			__construct($pageContext, $ignoreList)
	{
		parent::__construct();
		$this->pageContext = $pageContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			stringifyRef($ref)
	{
		$url = $ref->getUrl();
		switch ($ref->getType()) {
		case \net\dryuf\srvui\PageUrl::TYPE_FINAL:
			return $url;

		case \net\dryuf\srvui\PageUrl::TYPE_RELATIVE:
			return $url;

		case \net\dryuf\srvui\PageUrl::TYPE_ROOTED:
			return $this->pageContext->getContextPath().$url;

		case \net\dryuf\srvui\PageUrl::TYPE_LANGUAGED:
			return $this->pageContext->getContextPath()."/".$this->pageContext->getLanguage().$url;

		case \net\dryuf\srvui\PageUrl::TYPE_PAGED:
			return $this->pageContext->getContextPath()."/".$this->pageContext->getLanguage()."/".(strlen($url) != 0 ? $url."/" : "");

		default:
			throw new \net\dryuf\core\RuntimeException("cannot stringify ref of type ".$ref->getType());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	protected			$pageContext;
};


?>
