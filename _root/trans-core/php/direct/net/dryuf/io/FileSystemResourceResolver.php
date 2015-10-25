<?php

namespace net\dryuf\io;


class FileSystemResourceResolver extends \net\dryuf\io\AbstractResourceResolver
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
	public function			setPaths($paths)
	{
		$i = 0;
		$this->paths = \net\dryuf\core\Dryuf::allocArray(null, count($paths));
		foreach ($paths as $pathDef) {
			$pathSplit = \net\dryuf\core\StringUtil::splitRegExp($pathDef, "=", 2);
			if (count($pathSplit) != 2 || (!(substr($pathSplit[0], -strlen("/")) == "/") && strlen($pathSplit[0]) != 0) || !(substr($pathSplit[1], -strlen("/")) == "/"))
				throw new \net\dryuf\core\IllegalArgumentException("Invalid path definition, must contain 'prefix/=filesystem-path/': ".$pathDef);
			$this->paths[$i++] = new \net\dryuf\io\FileSystemResourceResolver\PathDef($pathSplit[0], $pathSplit[1]);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			checkFileType($path)
	{
		foreach ($this->paths as $pathDef) {
			if (!(substr($path, 0, strlen($pathDef->prefix)) == $pathDef->prefix))
				continue;
			$file = $pathDef->path."/".strval(substr($path, strlen($pathDef->prefix)));
			if (!file_exists($file))
				continue;
			if (is_file($file))
				return 1;
			if (is_dir($file))
				return 0;
			return -1;
		}
		return -1;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getResource($path)
	{
		foreach ($this->paths as $pathDef) {
			if (!(substr($path, 0, strlen($pathDef->prefix)) == $pathDef->prefix))
				continue;
			$file = $pathDef->path."/".strval(substr($path, strlen($pathDef->prefix)));
			if (file_exists($file)) {
				$contentType = \net\dryuf\core\Dryuf::defvalue($this->mimeTypeService->guessContentTypeFromName($path), "application/octet-stream");
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
				$fileData->setName($path);
				$fileData->setSize(filesize($file));
				$fileData->setModifiedTime(filemtime($file)*1000);
				return $fileData;
			}
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			getResourcePaths($path)
	{
		$result = new \net\dryuf\util\php\StringNativeHashSet();
		foreach ($this->paths as $pathDef) {
			if (!(substr($path, 0, strlen($pathDef->prefix)) == $pathDef->prefix))
				continue;
			$file = $pathDef->path."/".strval(substr($path, strlen($pathDef->prefix)));
			if (!is_dir($file))
				continue;
			foreach ((=f_I_x=)file.list()(=x_I_f=) as $name) {
				if (is_dir($file."/".$name))
					$name .= "/";
				$result->add($name);
			}
		}
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileSystemResourceResolver\PathDef[]')
	*/
	protected			$paths;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\text\mime\MimeTypeService')
	@\javax\inject\Inject
	*/
	protected			$mimeTypeService;
};


?>
