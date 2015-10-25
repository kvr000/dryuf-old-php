<?php

namespace net\dryuf\comp\gallery\convert;


class DigikamGalleryReader extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($callerContext, $options)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
		$this->useOrig = $options->getOptionDefault("useOrig", true);
		$this->isMulti = $options->getOptionMandatory("isMulti");
		$this->databaseFile = $options->getOptionMandatory("databaseFile");
		if (is_null(($this->sortField = $options->getOptionDefault("sortField", null))))
			$this->sortField = "imageid";
		switch ($this->sortField) {
		case "imageid":
		case "creationDate":
			break;

		default:
			throw new \net\dryuf\core\RuntimeException("invalid sortField: ".$this->sortField);
		}
		try {
			"org.sqlite.JDBC";
			$this->dbConnection = \java\sql\DriverManager::getConnection("jdbc:sqlite:".$this->databaseFile.";open_mode=1");
		}
		catch (\net\dryuf\core\Exception $e1) {
			throw new \net\dryuf\core\RuntimeException($e1);
		}
		$this->disabledTagId = \net\dryuf\sql\SqlHelper::runField($this->dbConnection, "id", "Tags", "name", "disabled");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\util\Map<java\lang\String, java\lang\Object>>')
	*/
	public function			listGalleries()
	{
		return \net\dryuf\sql\SqlHelper::queryRows($this->dbConnection, "SELECT AlbumRoots.label, AlbumRoots.specificPath, Albums.id, Albums.relativePath FROM Albums INNER JOIN AlbumRoots ON AlbumRoots.id = Albums.albumRoot", array( ));
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			setGalleries($rootId, $galleryPath)
	{
		$galleryPath = \net\dryuf\core\StringUtil::replaceRegExp($galleryPath, "/+\$", "");
		$albumRoot = \net\dryuf\sql\SqlHelper::queryOneRow($this->dbConnection, "SELECT id, specificPath FROM AlbumRoots WHERE label = ?", 
			array(
				$rootId
			));
		if ($this->useOrig) {
			$this->galleries = \net\dryuf\sql\SqlHelper::queryRows($this->dbConnection, "SELECT id, relativePath, caption, collection FROM Albums WHERE albumRoot = ? AND relativePath LIKE ? AND relativePath LIKE '%/orig' ORDER BY relativePath", 
				array(
					$albumRoot->get("id"),
					$galleryPath.($this->isMulti ? "/%" : "")."/orig"
				));
		}
		else {
			$this->galleries = \net\dryuf\sql\SqlHelper::queryRows($this->dbConnection, "SELECT id, relativePath, caption, collection FROM Albums WHERE albumRoot = ? AND relativePath LIKE ? AND relativePath NOT LIKE '%/thumb' AND relativePath NOT LIKE '%/orig' ORDER BY relativePath", 
				array(
					$albumRoot->get("id"),
					$galleryPath.($this->isMulti ? "/%" : "")
				));
		}
		return $this->galleries->size();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			writeToXmlGallery($writer)
	{
		$writer->startOutput();
		$writer->openLocations();
		$writer->openLocation(\net\dryuf\core\Options::buildListed("id", "", "store", "", "thumb", ""));
		$writer->closeLocation();
		$writer->closeLocations();
		$writer->openSections($this->isMulti);
		foreach ($this->galleries as $gallery) {
			$writer->openSection(\net\dryuf\core\Options::buildListed("id", $this->getGalleryName($gallery), "location", "", "title", $gallery->get("caption")));
			$writer->openRecords();
			foreach (\net\dryuf\sql\SqlHelper::queryRows($this->dbConnection, "SELECT i.id, i.name FROM Images i LEFT JOIN ImageInformation info ON info.imageid = i.id WHERE i.album = ? AND i.id NOT IN (SELECT it.imageid FROM ImageTags it WHERE it.tagid = ?) ORDER BY info.".$this->sortField.", i.id", 
				array(
					$gallery->get("id"),
					$this->disabledTagId
				)) as $image) {
				$origName = $image->get("name");
				$name = $origName;
				$extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
				if (self::$videoExtensions->containsKey($extension)) {
					$name = preg_replace(',\.[^/]*,', '', $name).".jpg";
				}
				$writer->openRecord(\net\dryuf\core\Options::buildListed("file", $name, "title", $this->getBestImageDesc($image), "description", $this->getBestImageDesc($image), "recordType", self::$videoExtensions->containsKey($extension) ? "video" : "picture"));
				if (self::$videoExtensions->containsKey($extension)) {
					$writer->openSources();
					$writer->openSource(\net\dryuf\core\Options::buildListed("file", $origName, "mimeType", self::$videoExtensions->get($extension)));
					$writer->closeSource();
					$writer->closeSources();
				}
				$writer->closeRecord();
			}
			$writer->closeRecords();
			$writer->closeSection();
		}
		$writer->closeSections();
		$writer->finishOutput();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getGalleryName($gallery)
	{
		return basename($this->useOrig ? dirname($gallery->get("relativePath")) : $gallery->get("relativePath"));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getBestImageDesc($image)
	{
		$comments = \net\dryuf\sql\SqlHelper::queryRows($this->dbConnection, "SELECT language, comment FROM ImageComments WHERE imageId = ? ORDER BY id", 
			array(
				$image->get("id")
			));
		if ($comments->size() == 0)
			return null;
		return $comments->get(0)->get("comment");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$disabledTagId = null;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$databaseFile;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isMulti = false;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\util\Map<java\lang\String, java\lang\Object>>')
	*/
	protected			$galleries;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$useOrig = false;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$sortField;

	/**
	@\net\dryuf\core\Type(type = 'java\sql\Connection')
	*/
	protected			$dbConnection;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	static				$videoExtensions;

	public static function		_initManualStatic()
	{
		self::$videoExtensions = \net\dryuf\util\MapUtil::createStringNativeHashMap("mp4", "video/mp4", "avi", "video/avi");
	}

};

\net\dryuf\comp\gallery\convert\DigikamGalleryReader::_initManualStatic();


?>
