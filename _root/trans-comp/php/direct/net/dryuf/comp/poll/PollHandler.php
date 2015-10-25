<?php

namespace net\dryuf\comp\poll;


interface PollHandler
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			getCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHeader')
	*/
	function			getPollDetail();

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			getPollTotal();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			addPollVote($userId, $voteId);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			deletePoll();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			cleanPoll();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<net\dryuf\comp\poll\PollOption>')
	*/
	function			getPollOptions();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			cleanOptions();
};


?>
