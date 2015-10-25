<?php

namespace net\dryuf\mvp\proc;


class CaptchaExport extends \net\dryuf\mvp\GenericFilePresenter
{
	/**
	*/
	function			__construct($parent_presenter, $options)
	{
		parent::__construct($parent_presenter, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	protected function		resolveFileData()
	{
		if (!is_null($this->getRootPresenter()->getPathElement()))
			return null;
		$captchaService = $this->getCallerContext()->getBeanTyped("captchaService", 'net\dryuf\service\image\CaptchaService');
		$captchaFile = $captchaService->generateCaptcha();
		\net\dryuf\mvp\FormPresenter::setRequestCaptcha($this->getRequest(), $captchaFile->getName());
		return $captchaFile;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		serveFile($fileData)
	{
		$response = $this->getResponse();
		$response->setContentType($fileData->getContentType());
		$response->setHeader("Pragma", "no-cache");
		$response->setHeader("Cache-Control", "no-cache, no-store");
		$size = $fileData->getSize();
		if ($size >= 0)
			$response->setLongHeader("Content-Length", $size);
		stream_copy_to_stream($fileData->getInputStream(), $response->getOutputStream());
	}
};


?>
