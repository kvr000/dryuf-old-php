<?php

namespace net\dryuf\comp\devel\mvp;


class DevelFilesPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->develFileDao = $this->getCallerContext()->getBeanTyped("develFileDao", 'net\dryuf\comp\devel\dao\DevelFileDao');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\devel\form\DevelAddFileForm')
	*/
	public function			createBackingObject()
	{
		return new \net\dryuf\comp\devel\form\DevelAddFileForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if (!is_null(($uploaded = $this->getRequest()->getParamDefault("uploaded", null)))) {
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\comp\devel\mvp\DevelFilesPresenter', "Your file has been successfully uploaded.");
		}
		return parent::processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\comp\devel\mvp\DevelFilesFilePresenter', $this, \net\dryuf\core\Options::$NONE)->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		if (!is_null($this->getLeadChild())) {
			$this->getLeadChild()->render();
		}
		else {
			parent::render();
			$dtTextual = \net\dryuf\textual\TextualManager::createTextual('net\dryuf\textual\UtcDateTimeTextual', $this->getCallerContext());
			$develFiles = new \net\dryuf\util\LinkedList();
			$this->develFileDao->listDynamic($develFiles, new \net\dryuf\core\EntityHolder(null, $this->getCallerContext()), null, null, null, null);
			$this->output("<table>\n");
			$this->outputFormat("\t<tr><th>%S</th><th>%S</th><th>%S</th><th>%S</th></tr>\n", "", "Time", "Name", "Size");
			foreach ($develFiles as $develFileEnt) {
				$develFile = $develFileEnt->getEntity();
				try {
					$this->outputFormat("\t<tr><td><a href=\"%S/?action=GET\">%S</a> <a href=\"%S/?action=DELETE\">%S</a></td><td align='right'>%K</td><td>%S</td><td align='right'>%S</td></tr>\n", urlencode(strval($develFile->getCreated())), "Get", urlencode(strval($develFile->getCreated())), "Delete", $dtTextual, $develFile->getCreated(), $develFile->getFileName(), strval($develFile->getFileSize()));
				}
				catch (\java\io\UnsupportedEncodingException $e) {
					throw new \net\dryuf\core\RuntimeException($e);
				}
			}
			$this->output("</table>\n");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performAddFile($action)
	{
		$develAddFileForm = $this->getBackingObject();
		$file = $this->getRequest()->getFile($this->getFormFieldName("file"));
		$develFile = new \net\dryuf\comp\devel\DevelFile();
		$develFile->setCreated(intval(microtime(true)*1000));
		$develFile->setFileName($file->getName());
		$develFile->setFileContent(stream_get_contents($file->getInputStream()));
		$develFile->setFileSize($file->getSize());
		$this->develFileDao->insert($develFile);
		$this->getRootPresenter()->redirect(\net\dryuf\srvui\PageUrl::createFinal("?done=POST&name=".urlencode($file->getName())));
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\devel\dao\DevelFileDao')
	*/
	protected			$develFileDao;
};


?>
