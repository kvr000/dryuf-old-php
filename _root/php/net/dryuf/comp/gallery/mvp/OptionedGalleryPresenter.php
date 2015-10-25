<?php

namespace net\dryuf\comp\gallery\mvp;


class OptionedGalleryPresenter extends \net\dryuf\comp\gallery\mvp\GalleryPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options, \net\dryuf\comp\gallery\mvp\OptionedGalleryPresenter::createGalleryHandler($parentPresenter, $options));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHandler')
	*/
	public static function		createGalleryHandler($parentPresenter, $options)
	{
		$callerContext = $parentPresenter->getCallerContext();
		if (!is_null(($roleMapping = $options->getOptionDefault("roleMapping", null))))
			$callerContext = \net\dryuf\core\RoleContext::createMapped($callerContext, $roleMapping);
		$galleryType = $options->getOptionMandatory("galleryType");
		switch ($galleryType) {
		case "xml":
			return new \net\dryuf\comp\gallery\xml\XmlDomGalleryHandler($callerContext, $parentPresenter->getRootPresenter()->getRealPath());

		case "dir":
			return new \net\dryuf\comp\gallery\dir\DirGalleryHandler($callerContext, $parentPresenter->getRootPresenter()->getRealPath());

		default:
			throw new \net\dryuf\core\RuntimeException("unknown gallery handler type: ".$galleryType."");
		}
	}
};


?>
