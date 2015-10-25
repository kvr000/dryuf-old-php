<?php

namespace net\dryuf\comp\forum\bo;


interface ForumBo
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\forum\ForumHeader>')
	*/
	function			getForumObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	function			openCreateForumRef($callerContext, $refBase, $refKey, $label);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteStaticRef($callerContext, $refBase, $refKey);
};


?>
