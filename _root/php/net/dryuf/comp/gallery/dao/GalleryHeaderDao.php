<?php

namespace net\dryuf\comp\gallery\dao;


interface GalleryHeaderDao extends \net\dryuf\dao\DynamicDao
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	function			refresh($obj);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	function			loadByPk($pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	function			listAll();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			insert($obj);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			insertTxNew($obj);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	function			update($obj);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			remove($obj);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			removeByPk($pk);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	function			importDynamicKey($data);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	function			exportDynamicData($holder);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	function			exportEntityData($holder);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	function			createDynamic($composition, $data);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\gallery\GalleryHeader>')
	*/
	function			retrieveDynamic($composition, $pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	function			updateDynamic($roleObject, $pk, $updates);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteDynamic($composition, $pk);

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			listDynamic($results, $composition, $filter, $sorts, $start, $limit);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\transaction\TransactionHandler')
	*/
	function			keepContextTransaction($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			runTransactioned($code);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			runTransactionedNew($code);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	*/
	function			loadByRef($refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			updateHeaderStats($galleryId);
};


?>
