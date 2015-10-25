<?php

namespace net\dryuf\oper;


class MetaExport extends \net\dryuf\core\Object
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
	public static function		formatClassName($clazz)
	{
		return \net\dryuf\core\StringUtil::replaceRegExp($clazz, "\\\$", ".");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		formatField($out, $callerContext, $classMeta, $fieldDef)
	{
		try {
			$fieldRoles = $fieldDef->getRoles();
			$assocClass = $fieldDef->getAssocClass();
			if (is_null($fieldRoles))
				$fieldRoles = $classMeta->getEntityRoles();
			\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<field name=%A", $fieldDef->getName());
			\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " assocType=%A roleGet=%A roleSet=%A roleNew=%A", !is_null($assocClass) ? $classMeta->formatAssocType($fieldDef->getAssocType()) : $classMeta->formatAssocType($fieldDef->getAssocType()), $fieldRoles->roleGet(), $fieldRoles->roleSet(), $fieldRoles->roleNew());
			if (!is_null($fieldDef->getAssocClass()))
				\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "ref", \net\dryuf\oper\MetaExport::formatClassName($fieldDef->getAssocClass()));
			if ($fieldDef->getAssocType() == \net\dryuf\app\FieldDef::AST_Compos) {
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, ">");
			}
			elseif (!is_null($fieldDef->getEmbedded())) {
				\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "embedded", \net\dryuf\oper\MetaExport::formatClassName($fieldDef->getEmbedded()->getDataClass()));
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, ">\n");
				\net\dryuf\oper\MetaExport::formatFields($out, $callerContext, $fieldDef->getEmbedded());
			}
			else {
				\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "mandatory", $fieldDef->getMandatory() ? "1" : "0");
				if (!is_null($fieldDef->getDoMandatory()))
					\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "doMandatory", strval($fieldDef->getDoMandatory()));
				if (!is_null($fieldDef->getAssocClass()))
					\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "assoc", \net\dryuf\oper\MetaExport::formatClassName($fieldDef->getAssocClass()));
				if (!is_null($fieldDef->getDisplay()))
					\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "display", $fieldDef->getDisplay());
				if (!is_null($fieldDef->getTextual()))
					\net\dryuf\xml\util\XmlFormat::appendAttributeSb($out, "textual", \net\dryuf\oper\MetaExport::formatClassName($fieldDef->getTextual()));
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, ">");
			}
			\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "</field>\n");
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("Failed to format ".$fieldDef->getName().": ".strval($ex), $ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		formatFields($out, $callerContext, $classMeta)
	{
		\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<fields name=%A>\n", \net\dryuf\oper\MetaExport::formatClassName($classMeta->getDataClass()));
		foreach ($classMeta->getFieldOrder() as $fieldName) {
			$field = $classMeta->getField($fieldName);
			\net\dryuf\oper\MetaExport::formatField($out, $callerContext, $classMeta, $field);
		}
		$out->append("</fields>\n");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		buildMeta($callerContext, $clazz, $viewName, $rpcPath)
	{
		if (is_null($viewName))
			$viewName = "Default";
		$classMeta = \net\dryuf\app\ClassMetaManager::openCached($callerContext->getAppContainer(), $clazz, $viewName);
		$classRoles = $classMeta->getEntityRoles();
		try {
			$out = new \net\dryuf\core\StringBuilder("<?xml version='1.0' encoding='UTF-8' ?>\n");
			\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<meta xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns=\"http://dryuf.org/schema/net/dryuf/app/meta/\" xsi:schemaLocation=\"http://dryuf.org/schema/net/dryuf/app/meta/ http://www.znj.cz/schema/net/dryuf/app/meta.xsd\" name=%A rpc=%A >\n", \net\dryuf\oper\MetaExport::formatClassName($clazz), $rpcPath);
			$relations = new \net\dryuf\util\php\StringNativeHashMap();
			{
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<req roleGet=%A roleSet=%A roleNew=%A roleDel=%A />\n", $classRoles->roleGet(), $classRoles->roleSet(), $classRoles->roleNew(), $classRoles->roleDel());
			}
			if (!is_null($classMeta->getPkName())) {
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<pkeyDef pkEmbedded=%A pkClass=%A pkField=%A additionalPkFields=%A", $classMeta->isPkEmbedded() ? "1" : "0", \net\dryuf\oper\MetaExport::formatClassName($classMeta->getPkClass()), $classMeta->getPkName(), \net\dryuf\core\StringUtil::joinArray(",", $classMeta->getAdditionalPkFields()));
				if ($classMeta->hasCompos())
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " composClass=%A composPkClass=%A composPath=%A", \net\dryuf\oper\MetaExport::formatClassName($classMeta->getComposClass()), \net\dryuf\oper\MetaExport::formatClassName($classMeta->getComposPkClass()), $classMeta->getComposPath());
				$out->append(">\n</pkeyDef>\n");
			}
			$fieldOrder = $classMeta->getFieldOrder();
			{
				$refFields = $classMeta->getRefFields();
				if (count($refFields) == 0)
					$refFields = $fieldOrder;
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<refFields fields=%A />\n", \net\dryuf\core\StringUtil::joinArray(",", $refFields));
			}
			{
				$out->append("<relations>\n");
				foreach ($classMeta->getRelations()->values() as $relationDef) {
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<relation name=%A targetClass=%A/>\n", $relationDef->name(), $relationDef->targetClass());
					$relations->put($relationDef->name(), $relationDef);
				}
				$out->append("</relations>\n");
			}
			\net\dryuf\oper\MetaExport::formatFields($out, $callerContext, $classMeta);
			$actionDefs = $classMeta->getActions();
			{
				$out->append("<actions>\n");
				foreach ($actionDefs as $actionDef) {
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "<action name=%A isStatic=%A guiDef=%A formName=%A formActioner=%A reqMode=%A roleAction=%A/>\n", $actionDef->name(), ($actionDef->isStatic() ? "1" : "0"), $actionDef->guiDef(), $actionDef->formName(), $actionDef->formActioner(), $actionDef->reqMode(), $actionDef->roleAction());
				}
				$out->append("</actions>\n");
			}
			{
				$vi = $classMeta->getViewInfo();
				$out->append("<view");
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " name=%A", $vi->name());
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " supplier=%A", $vi->supplier());
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " renderer=%A", $vi->renderer());
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " clientClass=%A", $vi->clientClass());
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " fields=\"");
				if (count($vi->fields()) == 1 && ($vi->fields()[0] === "")) {
					$needComma = false;
					if ($classMeta->isPkEmbedded() && count($classMeta->getAdditionalPkFields()) > 0) {
						\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "%S", \net\dryuf\core\StringUtil::joinArray(",", $classMeta->getAdditionalPkFields()));
						$needComma = true;
					}
					if (count($fieldOrder) > 0) {
						if ($needComma)
							\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, ",");
					}
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "%S", \net\dryuf\core\StringUtil::joinArray(",", $fieldOrder));
				}
				else {
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "%S", \net\dryuf\core\StringUtil::joinArray(",", $vi->fields()));
				}
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "\"");
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, " actions=\"");
				if (count($vi->actions()) == 1 && ($vi->actions()[0] === "")) {
					$list = new \net\dryuf\util\LinkedList();
					foreach ($actionDefs as $actionDef) {
						$list->add($actionDef->name());
					}
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "%S", \net\dryuf\core\StringUtil::joinArray(",", $list->toArray(\net\dryuf\core\StringUtil::$STRING_EMPTY_ARRAY)));
				}
				else {
					\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "%S", \net\dryuf\core\StringUtil::joinArray(",", $vi->actions()));
				}
				\net\dryuf\xml\util\XmlFormat::formatSb($out, $callerContext, "\"");
				$out->append("/>\n");
			}
			$out->append("</meta>\n");
			return strval($out);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("build meta failed for ".$clazz.": ".$ex->getMessage(), $ex);
		}
	}
};


?>
