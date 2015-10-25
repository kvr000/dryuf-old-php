<?php

namespace net\dryuf\comp\gallery;


interface GalleryHandler
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			getCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			read();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			supportsResource($name);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			isMulti();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	function			setCurrentSectionIdx($idx);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	function			setCurrentSection($name);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	function			setCurrentRecord($section, $thumb, $recordName);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			addSection($sectionInfo);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			addRecord($recordInfo, $imageContent);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySection>')
	*/
	function			listSections();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	*/
	function			listSectionRecords();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	function			getSectionByRecord($record);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySource>')
	*/
	function			listRecordSources();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	*/
	function			getCurrentSection();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	function			getCurrentRecord();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	function			getSectionDirs();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord[]')
	*/
	function			getFullDirs();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getResourceData($name);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getRecordData($record);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getRecordThumb($record);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			uploadResourceData($name, $resourceData);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			uploadRecordData($input);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			uploadRecordThumb($input);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			cleanGallery();
};


?>
