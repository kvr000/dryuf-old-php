<?php

namespace net\dryuf\menu\dao;


interface WebMenuItemDao extends \net\dryuf\dao\DynamicDao
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
	*/
	function			refresh($obj);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
	*/
	function			loadByPk($pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
	*/
	function			listByCompos($compos);

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			removeByCompos($compos);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebAccessiblePage\Pk')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
	*/
	function			createDynamic($composition, $data);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\menu\WebMenuItem>')
	*/
	function			retrieveDynamic($composition, $pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
	*/
	function			listRooted($providerName);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebMenuItem>')
	*/
	function			listByParent($providerName, $parentItem);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebAccessiblePage>')
	*/
	function			listPagesRooted($providerName);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\menu\WebAccessiblePage>')
	*/
	function			listPagesByParent($providerName, $parentItem);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\menu\WebMenuItem')
	*/
	function			loadByPageCode($providerName, $pageCode);
};


?>
