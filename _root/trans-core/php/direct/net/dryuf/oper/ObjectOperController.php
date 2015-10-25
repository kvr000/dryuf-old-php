<?php

namespace net\dryuf\oper;


interface ObjectOperController
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getDataClass();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operate($context, $ownerHolder);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getObjectId($context);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateStaticCommon($context, $ownerHolder);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController\RoleContainer')
	*/
	function			operateStaticRole($context, $ownerHolder);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			operateStaticMeta($context, $ownerHolder);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateStaticList($context, $ownerHolder);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateStaticSuggest($context, $ownerHolder);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateStaticCreate($context, $ownerHolder, $readValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateObjectCommon($context, $ownerHolder, $objectId);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateObjectRetrieve($context, $objectHolder);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateObjectUpdate($context, $objectHolder, $data);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			operateObjectDelete($context, $objectHolder);
};


?>
