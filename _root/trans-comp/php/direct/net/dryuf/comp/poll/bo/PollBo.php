<?php

namespace net\dryuf\comp\poll\bo;


interface PollBo
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	function			getGroupObject($callerContext, $groupId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	function			getGroupObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	function			getCreateGroupObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollGroupHandler')
	*/
	function			openCreateGroupRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteGroupStaticRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteGroupStatic($callerContext, $groupId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	function			getPollObject($callerContext, $pollId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	function			getPollObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	function			getCreatePollObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	function			openCreatePollRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deletePollStatic($callerContext, $pollId);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deletePollStaticRef($callerContext, $refBase, $refKey);
};


?>
