<?php

namespace net\dryuf\app;


interface FieldDef
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				AST_None = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				AST_Compos = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				AST_Reference = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				AST_Children = 3;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getName();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getPath();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getType();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			getAssocType();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	function			getEmbedded();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getAssocClass();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			getMandatory();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getDoMandatory();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getDisplay();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			getAlign();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	function			getRoles();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ReferenceDef')
	*/
	function			getReferenceDef();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\core\Textual<java\lang\Object>>')
	*/
	function			getTextual();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\core\Textual<java\lang\Object>>')
	*/
	function			needTextual();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getValue($o);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setValue($o, $value);
};


?>
