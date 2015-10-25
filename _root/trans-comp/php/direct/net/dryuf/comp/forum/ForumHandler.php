<?php

namespace net\dryuf\comp\forum;


interface ForumHandler
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			listComments($comments, $start, $limit);

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			addComment($forumRecord);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			cleanForum();
};


?>
