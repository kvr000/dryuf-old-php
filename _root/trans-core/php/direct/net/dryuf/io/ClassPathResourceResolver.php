<?php

namespace net\dryuf\io;


class ClassPathResourceResolver extends \net\dryuf\io\AbstractResourceResolver
{
	/**
	*/
	function			__construct()
	{
		$this->logger = \org\apache\logging\log4j\LogManager::getLogger(get_class($this));

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'org\apache\logging\log4j\Logger')
	*/
	protected			$logger;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\AppContainer')
	@\javax\inject\Inject
	*/
	protected			$appContainer;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			checkFileType($path)
	{
		return 1;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getResource($fullfilename)
	{
		try {
			$url = (=f_I_x=)getClass().getClassLoader()(=x_I_f=)->getResource($fullfilename);
			if (is_null($url))
				return null;
			return \net\dryuf\io\FileDataImpl::createFromUrl($url);
		}
		catch (\net\dryuf\core\Exception $ex) {
			$this->logger->error("Failed to open '".$fullfilename."'", $ex);
			return null;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			getResourcePaths($path)
	{
		throw new \net\dryuf\core\UnsupportedOperationException();
	}
};


?>
