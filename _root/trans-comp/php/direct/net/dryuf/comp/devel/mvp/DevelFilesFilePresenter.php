<?php

namespace net\dryuf\comp\devel\mvp;


class DevelFilesFilePresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\devel\dao\DevelFileDao')
	*/
	protected			$develFileDao;

	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->develFileDao = $this->getCallerContext()->getBeanTyped("develFileDao", 'net\dryuf\comp\devel\dao\DevelFileDao');
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		$filename = $this->parentPresenter->getRootPresenter()->getLastElementWithoutSlash();
		$this->develFile = $this->develFileDao->loadByPk(\net\dryuf\core\Dryuf::parseInt($filename));
		if (is_null($this->develFile)) {
			return $this->createNotFoundPresenter()->process();
		}
		elseif (is_null($this->getRootPresenter()->needPathSlash(true))) {
			return false;
		}
		return parent::processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$action = $this->getRootPresenter()->getRequest()->getParam("action");
		if (($action === "GET")) {
			$response = $this->getRootPresenter()->getResponse();
			$response->setContentType("application/octet-stream");
			$response->setDateHeader("Last-Modified", $this->develFile->getCreated());
			try {
				$response->setHeader("Content-Disposition", "inline; filename=".urlencode($this->develFile->getFileName()));
			}
			catch (\java\io\UnsupportedEncodingException $ex) {
				throw new \net\dryuf\core\RuntimeException($ex);
			}
			try {
				fwrite($response->getOutputStream(), $this->develFile->getFileContent());
			}
			catch (\net\dryuf\io\IoException $ex) {
				throw new \net\dryuf\core\RuntimeException($ex);
			}
		}
		elseif (($action === "DELETE")) {
			return true;
		}
		elseif (($action === "DELETE_CONFIRM")) {
			$this->develFileDao->removeByPk($this->develFile->getPk());
			$this->getRootPresenter()->redirect(\net\dryuf\srvui\PageUrl::createRelative("../?performed=DELETE"));
		}
		else {
			throw new \net\dryuf\core\RuntimeException("unknown action: ".$action);
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<p>Please <a href=\"%U\">confirm deletion of %S</a>.</p>\n", \net\dryuf\srvui\PageUrl::createRelative("?action=DELETE_CONFIRM"), $this->develFile->getFileName());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\devel\DevelFile')
	*/
	protected			$develFile;
};


?>
