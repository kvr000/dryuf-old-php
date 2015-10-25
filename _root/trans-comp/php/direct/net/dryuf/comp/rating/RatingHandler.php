<?php

namespace net\dryuf\comp\rating;


interface RatingHandler
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			getCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			deleteRating();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			cleanRating();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			getMaxRating();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHeader')
	*/
	function			getRatingDetail();

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	function			getRatingValue();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addRating($userId, $value);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			removeUserRating($userId);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\rating\RatingRecord>')
	*/
	function			listRatings();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			refresh();
};


?>
