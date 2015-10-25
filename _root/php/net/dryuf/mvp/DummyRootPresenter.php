<?php

namespace net\dryuf\mvp;


class DummyRootPresenter extends \net\dryuf\mvp\CommonRootPresenter
{
	/**
	*/
	function			__construct($callerContext, $request)
	{
		$this->outputStream = \net\dryuf\io\IoUtil::openMemoryStream("");

		parent::__construct($callerContext, $request);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\RootPresenter')
	*/
	public static function		createFullyDummy($callerContext)
	{
		$presenter = new \net\dryuf\mvp\DummyRootPresenter($callerContext, new \net\dryuf\srvui\DummyRequest());
		$presenter->initUiContext("");
		return $presenter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDeniedPresenter()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("createDeniedPresenter");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createNotFoundPresenter()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("createNotFoundPresenter");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createUnallowedMethodPresenter()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("createUnallowedMethodPresenter");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			output($text)
	{
		try {
			fwrite($this->outputStream, $text);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\ByteArrayOutputStream')
	*/
	public function			getOutputStream()
	{
		return $this->outputStream;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			getOutput()
	{
		return \net\dryuf\io\IoUtil::readMemoryStreamContent($this->outputStream);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\io\ByteArrayOutputStream')
	*/
	protected			$outputStream;
};


?>
