<?php

namespace net\dryuf\comp\gallery\GalleryRecord;


class RecordType extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				RT_Unknown = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				RT_Picture = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				RT_Video = 2;
};


?>
