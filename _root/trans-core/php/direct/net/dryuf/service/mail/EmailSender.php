<?php

namespace net\dryuf\service\mail;


interface EmailSender
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			mailUtf8($to, $subject, $content, $from);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			mailAttachment($to, $subject, $content, $from, $attachment);
};


?>
