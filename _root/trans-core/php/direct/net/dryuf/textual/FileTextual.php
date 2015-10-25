<?php

namespace net\dryuf\textual;


class FileTextual extends \net\dryuf\textual\LineTrimTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		checkFileName($callerContext, $filename)
	{
		if (\net\dryuf\core\StringUtil::indexOf($filename, "/") >= 0)
			return $callerContext->getUiContext()->localize('net\dryuf\textual\FileTextual', "File name cannot contain '/'");
		if (\net\dryuf\core\StringUtil::indexOf($filename, ":") >= 0)
			return $callerContext->getUiContext()->localize('net\dryuf\textual\FileTextual', "File name cannot contain ':'");
		if (($filename === ".") || ($filename === ".."))
			return $callerContext->getUiContext()->localize('net\dryuf\textual\FileTextual', "File name cannot be . or ..");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($input)
	{
		return \net\dryuf\textual\FileTextual::checkFileName($this->getCallerContext(), $input);
	}
};


?>
