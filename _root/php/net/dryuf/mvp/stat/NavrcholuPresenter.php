<?php

namespace net\dryuf\mvp\stat;


class NavrcholuPresenter extends \net\dryuf\mvp\NoLeadChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->nav_site = $options->getOptionMandatory("site");
		$this->nav_t = $options->getOptionMandatory("t");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<script src=\"http://c1.navrcholu.cz/code?site=%S;t=%S\" type=\"text/javascript\"></script><noscript><div><a href=\"http://navrcholu.cz/\"><img src=\"http://c1.navrcholu.cz/hit?site=%S;t=%S;ref=;jss=0\" width=\"24\" height=\"24\" alt=\"NAVRCHOLU.cz\" style=\"border:none\" /></a></div></noscript>", $this->nav_site, $this->nav_t, $this->nav_site, $this->nav_t);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$nav_site;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$nav_t;
};


?>
