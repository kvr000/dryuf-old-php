<?php

namespace net\dryuf\menu\dao;


interface WebLanguageDao extends \net\dryuf\dao\DynamicDao
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage')
	*/
	function			refresh($obj);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage')
	*/
	function			loadByPk($pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebLanguage>')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebLanguage>')
	*/
	function			listByCompos($compos);

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			removeByCompos($compos);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage\Pk')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage')
	*/
	function			createDynamic($composition, $data);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\menu\WebLanguage>')
	*/
	function			retrieveDynamic($composition, $pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebLanguage')
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
};


?>
