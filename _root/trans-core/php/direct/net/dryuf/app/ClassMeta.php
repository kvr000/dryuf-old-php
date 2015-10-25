<?php

namespace net\dryuf\app;


interface ClassMeta
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			convertField($callerContext, $fdef, $value);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getDataClassName();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			instantiate();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			canNew($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			canDel($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			hasCompos();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			isPkEmbedded();

	/**
	 * @return
	 * 	list of additional PK fields within
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getAdditionalPkFields();

	/**
	 * Gets list of field definitions.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>[]')
	*/
	function			getFields();

	/**
	 * Gets the field name of the key.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getRefName();

	/**
	 * Gets object key from the existing object.
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getEntityPkValue($entity);

	/**
	 * Sets object key.
	 */
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setEntityPkValue($entity, $value);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setComposKey($entity, $composKey);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getComposKey($entity);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef[]')
	*/
	function			getActions();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	function			getFieldRoles($name);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>')
	*/
	function			getField($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getEntityFieldValue($entity, $fieldName);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setEntityFieldValue($entity, $fieldName, $value);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>')
	*/
	function			getPathField($path);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getEntityPathValue($entity, $path);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setEntityPathValue($entity, $path, $value);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef')
	*/
	function			getAction($name);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\RelationDef')
	*/
	function			getRelation($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			urlDisplayKey($callerContext, $entity);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			urlPkEntityKey($callerContext, $pk);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	function			getGlobalActionList($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	function			getObjectActionList($obj);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getDataClass();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getDataView();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			getEmbedded();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ViewInfo')
	*/
	function			getViewInfo();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getPkClass();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getPkName();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getComposClass();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	function			getComposPkClass();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getComposPath();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	function			getEntityRoles();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getDbSource();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getDbTable();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getFieldOrder();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getSuggestFields();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getRefFields();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	function			getDisplayKeys();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\RelationDef>')
	*/
	function			getRelations();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDef<java\lang\Object>')
	*/
	function			getPkFieldDef();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\meta\FilterDef>')
	*/
	function			getFilterDefsHash();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			formatAssocType($assocType);
};


?>
