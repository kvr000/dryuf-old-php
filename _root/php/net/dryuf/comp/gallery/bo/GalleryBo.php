<?php

namespace net\dryuf\comp\gallery\bo;


interface GalleryBo
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	function			getGalleryObject($callerContext, $galleryId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	function			getGalleryObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	function			getCreateGalleryObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	function			openGallery($callerContext, $galleryId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	function			openGalleryRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	function			openCreateGalleryRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteGalleryStatic($callerContext, $galleryId);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteGalleryStaticRef($callerContext, $refBase, $refKey);
};


?>
