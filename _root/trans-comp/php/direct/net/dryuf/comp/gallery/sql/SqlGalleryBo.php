<?php

namespace net\dryuf\comp\gallery\sql;


class SqlGalleryBo extends \net\dryuf\core\Object implements \net\dryuf\comp\gallery\bo\GalleryBo
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	public function			getGalleryObject($callerContext, $galleryId)
	{
		$objects = new \net\dryuf\util\LinkedList();
		if ($this->galleryHeaderDao->listDynamic($objects, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("galleryId", $galleryId), null, null, null) == 0)
			return null;
		return $objects->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	public function			getGalleryObjectRef($callerContext, $refBase, $refKey)
	{
		$objects = new \net\dryuf\util\LinkedList();
		if ($this->galleryHeaderDao->listDynamic($objects, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("refBase", $refBase, "refKey", $refKey), null, null, null) == 0)
			return null;
		return $objects->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	public function			getCreateGalleryObjectRef($callerContext, $refBase, $refKey)
	{
		if (is_null(($objectHolder = $this->getGalleryObjectRef($callerContext, $refBase, $refKey)))) {
			try {
				$header = new \net\dryuf\comp\gallery\GalleryHeader();
				$header->setRefBase($refBase);
				$header->setRefKey($refKey);
				$header->setDisplayName($refKey);
				$header->setLastAdded(intval(microtime(true)*1000));
				$this->galleryHeaderDao->insert($header);
			}
			catch (\net\dryuf\dao\DaoUniqueConstraintException $ex) {
			}
			if (is_null(($objectHolder = $this->getGalleryObjectRef($callerContext, $refBase, $refKey)))) {
				throw new \net\dryuf\core\RuntimeException("failed to create gallery object");
			}
		}
		return $objectHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public function			openGallery($callerContext, $galleryId)
	{
		if (!is_null(($galleryHeaderHolder = $this->getGalleryObject($callerContext, $galleryId))))
			new \net\dryuf\comp\gallery\sql\SqlGalleryHandler($this, $galleryHeaderHolder);
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public function			openGalleryRef($callerContext, $refBase, $refKey)
	{
		if (!is_null(($galleryHeaderHolder = $this->getGalleryObjectRef($callerContext, $refBase, $refKey))))
			new \net\dryuf\comp\gallery\sql\SqlGalleryHandler($this, $galleryHeaderHolder);
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public function			openCreateGalleryRef($callerContext, $refBase, $refKey)
	{
		return new \net\dryuf\comp\gallery\sql\SqlGalleryHandler($this, $this->getCreateGalleryObjectRef($callerContext, $refBase, $refKey));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteGalleryStatic($callerContext, $galleryId)
	{
		if (!is_null(($galleryHandler = $this->openGallery($callerContext, $galleryId))))
			$galleryHandler->deleteGallery();
		return !is_null($galleryHandler);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteGalleryStaticRef($callerContext, $refBase, $refKey)
	{
		if (!is_null(($galleryHandler = $this->openGalleryRef($callerContext, $refBase, $refKey))))
			$galleryHandler->deleteGallery();
		return !is_null($galleryHandler);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\file\FileStoreService')
	@\javax\inject\Inject
	*/
	protected			$galleryStoreService;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\file\FileStoreService')
	*/
	public function			getGalleryStoreService()
	{
		return $this->galleryStoreService;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\image\ImageResizeService')
	@\javax\inject\Inject
	*/
	protected			$imageResizeService;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\image\ImageResizeService')
	*/
	public function			getImageResizeService()
	{
		return $this->imageResizeService;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GalleryHeaderDao')
	@\javax\inject\Inject
	*/
	protected			$galleryHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GalleryHeaderDao')
	*/
	public function			getGalleryHeaderDao()
	{
		return $this->galleryHeaderDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GallerySectionDao')
	@\javax\inject\Inject
	*/
	protected			$gallerySectionDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GallerySectionDao')
	*/
	public function			getGallerySectionDao()
	{
		return $this->gallerySectionDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GalleryRecordDao')
	@\javax\inject\Inject
	*/
	protected			$galleryRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\dao\GalleryRecordDao')
	*/
	public function			getGalleryRecordDao()
	{
		return $this->galleryRecordDao;
	}
};


?>
