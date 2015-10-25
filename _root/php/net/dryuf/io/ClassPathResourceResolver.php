<?php

namespace net\dryuf\io;


class ClassPathResourceResolver extends \net\dryuf\io\AbstractResourceResolver
{
	/**
	*/
	function			__construct()
	{
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
		$full = stream_resolve_include_path($fullfilename);
		if ($full === false)
			return null;
		return \net\dryuf\io\FileDataImpl::createFromFilename($full);
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
