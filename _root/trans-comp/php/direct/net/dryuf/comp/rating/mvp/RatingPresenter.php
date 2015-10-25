<?php

namespace net\dryuf\comp\rating\mvp;


class RatingPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options, $ratingHandler)
	{
		parent::__construct($parentPresenter, $options);
		$this->ratingHandler = $ratingHandler;
		$this->presenterPath = $options->getOptionDefault("presenterPath", "rating");
		$this->updatedEvent = $options->getOptionDefault("updatedEvent", null);
		if (is_null(($this->cssClass = $options->getOptionDefault("css", null)))) {
			$this->cssClass = $options->getOptionDefault("cssClass", "net.dryuf.comp.rating.RatingPresenter");
			$this->cssFile = $options->getOptionDefault("cssFile", \net\dryuf\core\Dryuf::pathClassname($this->cssClass));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		if (!is_null($this->cssFile))
			$this->getRootPresenter()->addLinkedFile("css", \net\dryuf\srvui\PageUrl::createResource($this->cssFile));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if (!is_null(($rating = $this->getRequest()->getParam("rating")))) {
			if ($this->ratingHandler->getCallerContext()->checkRole("Rating.rate")) {
				$this->ratingHandler->addRating(intval($this->getCallerContext()->getUserId()), \net\dryuf\core\Dryuf::parseInt($rating));
				if (!is_null($this->updatedEvent))
					\net\dryuf\core\Dryuf::invokeMethodString0($this->getParentPresenter(), $this->updatedEvent);
				$this->getRootPresenter()->getResponse()->redirect("../");
				return false;
			}
			else {
				$this->createDeniedPresenter();
			}
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<span class=\"%S\" title=\"%W\">", $this->cssClass, 'net\dryuf\comp\rating\mvp\RatingPresenter', $this->ratingHandler->getCallerContext()->checkRole("Rating.rate") ? "Rate here" : "Login to rate");
		$this->outputFormat("<span class='positive'>");
		for ($i = 1; $i <= $this->ratingHandler->getRatingValue(); $i++)
			$this->renderRatingStar($i);
		$this->outputFormat("</span><span class='none'>");
		for (; $i <= $this->ratingHandler->getMaxRating(); $i++)
			$this->renderRatingStar($i);
		$this->outputFormat("</span>");
		$this->outputFormat("</span>");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderRatingStar($i)
	{
		if (!$this->ratingHandler->getCallerContext()->checkRole("Rating.rate")) {
			$this->output("★");
		}
		else {
			$this->outputFormat("<a href=\"%S/?rating=%S\">★</a>", $this->presenterPath, strval($i));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHandler')
	*/
	protected			$ratingHandler;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHandler')
	*/
	public function			getRatingHandler()
	{
		return $this->ratingHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$presenterPath;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$updatedEvent;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$cssClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$cssFile;
};


?>
