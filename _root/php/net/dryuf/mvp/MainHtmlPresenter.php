<?php

namespace net\dryuf\mvp;


class MainHtmlPresenter extends \net\dryuf\mvp\MainXhtmlPresenter
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
	public function			headDocumentUtf8()
	{
		$this->getRootPresenter()->getResponse()->setContentType("text/html; charset=UTF-8");
		$this->getRootPresenter()->addMetaHttp("Content-Type", "text/html; charset=UTF-8");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderDocumentStart()
	{
		$this->output("<!DOCTYPE html>\n<html>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addW3CStat()
	{
		$this->addStat(new \net\dryuf\mvp\stat\W3cHtmlPresenter($this, \net\dryuf\core\Options::$NONE));
	}
};


?>
