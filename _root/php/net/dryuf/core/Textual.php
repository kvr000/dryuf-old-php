<?php

namespace net\dryuf\core;


/**
 * Convertor and formatter between internal value and its textual representation.
 */
interface Textual
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Textual<java\lang\Object>')
	*/
	function			setCallerContext($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			prepare($text, $style);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			check($text, $style);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			convert($text, $style);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			validate($internal);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			format($internal, $style);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			convertKey($text);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			formatKey($internal);
};


?>
