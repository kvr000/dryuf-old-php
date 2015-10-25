<?php

namespace net\dryuf\comp\rating\bo;


interface RatingBo
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	function			getRatingObject($callerContext, $pollId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	function			getRatingObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	function			getCreateRatingObjectRef($callerContext, $refBase, $refKey);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHandler')
	*/
	function			openCreateRatingRef($callerContext, $refBase, $refKey, $maxRating);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteRatingStatic($callerContext, $pollId);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			deleteRatingStaticRef($callerContext, $refBase, $refKey);
};


?>
