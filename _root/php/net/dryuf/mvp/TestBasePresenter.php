<?php

namespace net\dryuf\mvp;


class TestBasePresenter extends \net\dryuf\mvp\EmptyXhtmlPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\TestBasePresenter')
	*/
	public static function		createFromServlet($servlet, $request, $response)
	{
		return new \net\dryuf\mvp\TestBasePresenter(new \net\dryuf\mvp\WebRootPresenter(\net\dryuf\srvui\spring\SpringCallerContext::createFromServletContext($request->getServletContext()), new \net\dryuf\web\jee\JeeWebRequest($request, $response)), \net\dryuf\core\Options::$NONE);
	}

	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		\net\dryuf\core\Options::buildListed("nolead", false);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderContent()
	{
		$this->renderLeadChild();
	}
};


?>
