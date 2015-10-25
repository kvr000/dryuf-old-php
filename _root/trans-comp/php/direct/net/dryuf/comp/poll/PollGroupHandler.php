<?php

namespace net\dryuf\comp\poll;


interface PollGroupHandler
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	function			getLastHeader();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>>')
	*/
	function			listHeaders();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	function			createPoll($pollHeader);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	function			openPoll($pollId);
};


?>
