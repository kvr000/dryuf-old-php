<?php

namespace net\dryuf\core;


/**
 * {@code UiContext} represents the user localization behaviour.
 */
interface UiContext
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getDefaultLanguage();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getLanguage();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setLanguage($language);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			checkLanguage($language);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			listLanguages();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			getLocalizeDebug();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setLocalizeDebug($level);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			getTiming();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setTiming($timing);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getLocalizePath();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setLocalizeContextPath($path);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getLocalizeContextPath();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			localize($class_name, $text);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			localizeArgs($class_name, $text, $objects);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			localizeArgsEscape($escaper, $class_name, $text, $objects);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			readLocalizedFile($filename);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	function			getClassLocalization($className);
};


?>
