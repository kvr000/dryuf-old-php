<?php

namespace net\dryuf\service\file\fs;


class FsFileStoreService extends \net\dryuf\core\Object implements \net\dryuf\service\file\FileStoreService, \net\dryuf\core\AppContainerAware
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		if (is_null($this->root))
			throw new \net\dryuf\core\IllegalArgumentException("root not specified");
		if (!(substr($this->root, -strlen("/")) == "/"))
			throw new \net\dryuf\core\IllegalArgumentException("root must end with '/'");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			putFile($path, $filename, $content)
	{
		try {
			stream_copy_to_stream($content->getInputStream(), fopen($this->root.$path.$filename, "wb"));
		}
		catch (\net\dryuf\core\Exception $ex) {
			\net\dryuf\io\DirUtil::mkpath($this->root.$path);
			try {
				stream_copy_to_stream($content->getInputStream(), fopen($this->root.$path.$filename, "wb"));
			}
			catch (\net\dryuf\io\IoException $e) {
				throw new \net\dryuf\core\RuntimeException($e);
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getFile($path, $filename)
	{
		$file = $this->root.$path.$filename;
		if (!file_exists($file))
			return null;
		$contentType = $this->mimeTypeService->guessContentTypeFromName($filename);
		if (is_null($contentType))
			$contentType = "application/octet-stream";
		$fileData = new \net\dryuf\io\FileDataImpl()(=f_I_x=)
		class  {
		    
		    @Override()
		    public InputStream getInputStream() {
		        try {
		            return FileUtils.openInputStream(file);
		        } catch (IOException e) {
		            throw new RuntimeException(e);
		        }
		    }
		}(=x_I_f=);
		$fileData->setContentType($contentType);
		$fileData->setName($filename);
		$fileData->setSize(filesize($file));
		$fileData->setModifiedTime(filemtime($file)*1000);
		return $fileData;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			removeFile($path, $filename)
	{
		unlink($this->root.$path.$filename);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			removePath($path)
	{
		try {
			\net\dryuf\io\DirUtil::rmpath($this->root.$path);
		}
		catch (\net\dryuf\io\IoException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$root;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRoot($root_)
	{
		$this->root = $root_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\text\mime\MimeTypeService')
	@\javax\inject\Inject
	*/
	protected			$mimeTypeService;
};


?>
