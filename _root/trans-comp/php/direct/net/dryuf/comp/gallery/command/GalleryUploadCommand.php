<?php

namespace net\dryuf\comp\gallery\command;


class GalleryUploadCommand extends \net\dryuf\process\command\AbstractCommand
{
	/**
	*/
	function			__construct()
	{
		$this->actions = new \net\dryuf\util\LinkedList();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ACTION_Config = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				ACTION_Data = 1;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			main($arguments)
	{
		exit(\net\dryuf\process\command\ExternalCommandRunner::createFromClassPath()->runNew('net\dryuf\comp\gallery\command\GalleryUploadCommand', $arguments));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			parseArguments($arguments)
	{
		$this->options = \net\dryuf\util\MapUtil::createStringNativeHashMap("G", false, "D", false);
		return parent::parseArguments($arguments);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		validateArguments()
	{
		if ($this->options->get("G"))
			$this->actions->add(self::ACTION_Config);
		if ($this->options->get("D"))
			$this->actions->add(self::ACTION_Data);
		if ($this->actions->size() == 0)
			return $this->getUiContext()->localize('net\dryuf\comp\gallery\command\GalleryUploadCommand', "You have to specify action, e.g. -G or -D");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			reportUsage($reason)
	{
		return $this->commandRunner->reportUsage($reason, "Options: -u url -s sid [-h] [-G] [-D]\n\t-u url\tURL target (including final /)\n\t-s sid\tsession id\n\t-G\tupload gallery+xml\t\n\t-D\tupload records data\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			process()
	{
		$galleryUploader = new \net\dryuf\comp\gallery\mvp\GalleryUploader($this->callerContext, \net\dryuf\core\Options::buildListed("targetUrl", $this->options->get("u"), "sid", $this->options->get("s")), new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler($this->callerContext, "./"));
		foreach ($this->actions as $action) {
			switch ($action) {
			case self::ACTION_Config:
				$galleryUploader->uploadResources();
				break;

			case self::ACTION_Data:
				if (count($this->options->get("")) == 0) {
					$galleryUploader->uploadData();
				}
				else {
					foreach ($this->options->get("") as $element) {
						if (!is_null(($match = \net\dryuf\core\StringUtil::matchText("^([^/]+)/([^/]+)\$", $element)))) {
							$galleryUploader->uploadRecord($match[1], $match[2]);
						}
						elseif (!is_null(($match = \net\dryuf\core\StringUtil::matchText("^([^/]+)/\$", $element)))) {
							$galleryUploader->uploadSection($match[1]);
						}
						else {
							return $this->commandRunner->reportUsage("unexpected parameter ".$element."\nexpecting either full image filename or section/\n", null);
						}
					}
				}
				break;

			default:
				throw new \net\dryuf\core\RuntimeException("unhandled action: ".$action);
			}
		}
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Integer>')
	*/
	protected			$actions;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	public function			getOptionsDefinition()
	{
		return self::$optionsDefinition;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$options;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getOptions()
	{
		return $this->options;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	static				$optionsDefinition;

	public static function		_initManualStatic()
	{
		self::$optionsDefinition = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("u", 'net\dryuf\textual\LineTrimTextual', "s", 'net\dryuf\textual\LineTrimTextual', "G", null, "D", null, "h", null))->setMandatories(\net\dryuf\util\CollectionUtil::createLinkedHashSet("u", "s"))->setMinParameters(0)->setMaxParameters(2147483647);
	}

};

\net\dryuf\comp\gallery\command\GalleryUploadCommand::_initManualStatic();


?>
