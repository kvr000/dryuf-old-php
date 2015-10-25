<?php

namespace net\dryuf\comp\gallery\command;


class Digikam2GalleryCommand extends \net\dryuf\process\command\AbstractCommand
{
	/**
	*/
	function			__construct()
	{
		$this->actions = new \net\dryuf\util\LinkedList();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			main($arguments)
	{
		exit((new \net\dryuf\process\command\ExternalCommandRunner((new \org\springframework\context\support\ClassPathXmlApplicationContext())->getBean("appContainer", 'net\dryuf\core\AppContainer')->createCallerContext()))->runNew('net\dryuf\comp\gallery\command\Digikam2GalleryCommand', $arguments));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			parseArguments($arguments)
	{
		$this->options = \net\dryuf\util\MapUtil::createStringNativeHashMap("l", false, "m", false, "O", true, "s", null, "S", null);
		return parent::parseArguments($arguments);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			reportUsage($reason)
	{
		return $this->commandRunner->reportUsage($reason, "Options: -f dbfile [-m] [-O] -r root -g gallery\n\t-f db-file\t\tpath to digikam database\n\t-p gallery-root\t\tgallery root\n\t-g gallery-name\t\tgallery name\n\t-m\t\t\tis multi section gallery\n\t-O\t\t\tdo not use orig directory\n\t-s sort-field\t\tsort field\n\t-L\t\t\tlist galleries\n\t-S\t\t\tgenerated scaled\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validateArguments()
	{
		if ($this->options->containsKey("L"))
			return null;
		if ($this->options->containsKey("g")) {
			if (!$this->options->containsKey("p"))
				return $this->getCallerContext()->getUiContext()->localize('net\dryuf\comp\gallery\command\Digikam2GalleryCommand', "Option p is mandatory when g is specified.");
			return null;
		}
		return $this->getUiContext()->localize('net\dryuf\comp\gallery\command\Digikam2GalleryCommand', "One of options -L or -g is mandatory.");
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			process()
	{
		$this->galleryReader = new \net\dryuf\comp\gallery\convert\DigikamGalleryReader($this->callerContext, \net\dryuf\core\Options::buildListed("isMulti", $this->options->get("m"), "useOrig", $this->options->get("O"), "sortField", $this->options->get("s"), "databaseFile", $this->options->get("f")));
		if ($this->options->get("L") && ($error = $this->processList()) != 0) {
			return $error;
		}
		if ($this->options->get("g") && ($error = $this->processGenerating()) != 0)
			return $error;
		if ($this->options->get("S") && ($error = $this->processScale()) != 0)
			return $error;
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected function		processList()
	{
		fprintf(STDOUT, "%-19s %-39s %-39s %8s\n", "label", "specificPath", "relativePath", "id");
		foreach ($this->galleryReader->listGalleries() as $gallery) {
			fprintf(STDOUT, "%-19s %-39s %-39s %8d\n", $gallery->get("label"), $gallery->get("specificPath"), $gallery->get("relativePath"), $gallery->get("id"));
		}
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected function		processGenerating()
	{
		if ($this->galleryReader->setGalleries($this->options->get("p"), $this->options->get("g")) == 0) {
			fprintf(STDERR, "Warning: no gallery of name %s found\n", $this->options->get("g"));
		}
		$this->galleryReader->setGalleries($this->options->get("p"), $this->options->get("g"));
		$stream = \net\dryuf\io\IoUtil::openMemoryStream("");
		$this->galleryReader->writeToXmlGallery(new \net\dryuf\comp\gallery\convert\XmlGalleryWriter($this->callerContext, $stream));
		fputs(STDOUT, (\net\dryuf\io\IoUtil::readMemoryStreamContent($stream)));
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected function		processScale()
	{
		$errors = 0;
		$handler = new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler($this->getCallerContext(), "./");
		foreach ($handler->listSections() as $section) {
			$sectionRoot = $handler->isMulti() ? $section->getDisplayName()."/" : "";
			$handler->setCurrentSection($section->getDisplayName());
			foreach ($handler->listSectionRecords() as $record) {
				try {
					$origFile = $sectionRoot."orig/".$record->getDisplayName();
					$recordFile = $sectionRoot.$record->getDisplayName();
					$thumbFile = $sectionRoot."thumb/".$record->getDisplayName();
					if (!file_exists($recordFile) || filemtime($origFile)*1000 > filemtime($recordFile)*1000) {
						fputs(STDERR, "updating main for ".$record->getDisplayName()."\n");
						$scaledRecord = $this->imageResizeService->resizeToMaxWh(file_get_contents($origFile), 1000, 750, true, pathinfo($record->getDisplayName(), PATHINFO_EXTENSION));
						file_put_contents($recordFile, $scaledRecord);
					}
					if (!file_exists($thumbFile) || filemtime($recordFile)*1000 > filemtime($thumbFile)*1000) {
						\net\dryuf\io\DirUtil::mkpath($sectionRoot."thumb");
						fputs(STDERR, "updating thumb for ".$record->getDisplayName()."\n");
						$scaledThumb = $this->imageResizeService->resizeScale(file_get_contents($recordFile), 0.2, true, pathinfo($record->getDisplayName(), PATHINFO_EXTENSION));
						file_put_contents($thumbFile, $scaledThumb);
					}
				}
				catch (\Exception $e) {
					fputs(STDERR, "Failed to process ".$sectionRoot.$record->getDisplayName().": ".$e->getMessage()."\n");
					++$errors;
				}
			}
		}
		fputs(STDERR, "Done processing, ".$errors." errors noticed\n");
		return $errors != 0 ? 1 : 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\convert\DigikamGalleryReader')
	*/
	protected			$galleryReader;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Integer>')
	*/
	protected			$actions;

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
	@\net\dryuf\core\Type(type = 'net\dryuf\service\image\ImageResizeService')
	@\javax\inject\Inject
	*/
	protected			$imageResizeService;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	public function			getOptionsDefinition()
	{
		return self::$optionsDefinition;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\process\command\GetOptions')
	*/
	static				$optionsDefinition;

	public static function		_initManualStatic()
	{
		self::$optionsDefinition = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("m", null, "O", null, "f", 'net\dryuf\textual\TextTextual', "p", 'net\dryuf\textual\TextTextual', "g", 'net\dryuf\textual\TextTextual', "s", 'net\dryuf\textual\TextTextual', "h", null, "L", null, "S", null))->setMandatories(\net\dryuf\util\CollectionUtil::createLinkedHashSet("f"));
	}

};

\net\dryuf\comp\gallery\command\Digikam2GalleryCommand::_initManualStatic();


?>
