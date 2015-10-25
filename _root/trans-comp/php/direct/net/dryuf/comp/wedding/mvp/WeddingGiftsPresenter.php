<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_LIST = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_INFO = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_RESERVE = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_RESERVE_DONE = 3;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_CANCEL = 4;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_CANCEL_DONE = 5;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_PROPOSE = 6;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_PROPOSE_DONE = 7;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_COORDINATE = 8;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				MODE_COORDINATE_DONE = 9;

	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->weddingGiftsReference = $options->getOptionMandatory("refKey");
		$this->weddingGiftsHeaderDao = $this->getCallerContext()->getBeanTyped("weddingGiftsHeaderDao", 'net\dryuf\comp\wedding\dao\WeddingGiftsHeaderDao');
		$this->weddingGiftsGiftDao = $this->getCallerContext()->getBeanTyped("weddingGiftsGiftDao", 'net\dryuf\comp\wedding\dao\WeddingGiftsGiftDao');
		$headers = new \net\dryuf\util\LinkedList();
		$this->weddingGiftsHeaderDao->listDynamic($headers, \net\dryuf\core\EntityHolder::createRoleOnly($this->getCallerContext()), \net\dryuf\util\MapUtil::createStringNativeHashMap("refBase", \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\wedding\WeddingGiftsHeader'), "refKey", $this->weddingGiftsReference), null, null, null);
		if ($headers->size() != 1)
			throw new \net\dryuf\core\RuntimeException("No WeddingGiftsHeader found for reference ".\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\wedding\WeddingGiftsHeader')." ".$this->weddingGiftsReference);
		$this->weddingGiftsHeaderHolder = $headers->get(0);
		$this->weddingGiftsHeader = $this->weddingGiftsHeaderHolder->getEntity();
		$this->weddingGiftsId = $this->weddingGiftsHeader->getWeddingGiftsId();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getMode()
	{
		return $this->mode;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setMode($mode)
	{
		$this->mode = $mode;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		if (is_null(($subPresenter = self::$staticDivider->tryPage($this)))) {
			if (is_null($this->getRootPresenter()->needPathSlash(true)))
				return false;
			$subPresenter = new \net\dryuf\comp\wedding\mvp\WeddingGiftsGiftPresenter($this, \net\dryuf\core\Options::$NONE);
		}
		return $subPresenter->process();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsHeaderDao')
	*/
	protected			$weddingGiftsHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsHeaderDao')
	*/
	public function			getWeddingGiftsHeaderDao()
	{
		return $this->weddingGiftsHeaderDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsGiftDao')
	*/
	protected			$weddingGiftsGiftDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\dao\WeddingGiftsGiftDao')
	*/
	public function			getWeddingGiftsGiftDao()
	{
		return $this->weddingGiftsGiftDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$weddingGiftsReference;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\wedding\WeddingGiftsHeader>')
	*/
	protected			$weddingGiftsHeaderHolder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\wedding\WeddingGiftsHeader>')
	*/
	public function			getWeddingGiftsHeaderHolder()
	{
		return $this->weddingGiftsHeaderHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsHeader')
	*/
	protected			$weddingGiftsHeader;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsHeader')
	*/
	public function			getWeddingGiftsHeader()
	{
		return $this->weddingGiftsHeader;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	protected			$weddingGiftsId = 0;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getWeddingGiftsId()
	{
		return $this->weddingGiftsId;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$mode = 0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	public static			$staticDivider;

	public static function		_initManualStatic()
	{
		self::$staticDivider = new \net\dryuf\mvp\StaticPresenterDivider(
			array(
				\net\dryuf\mvp\PresenterElement::createClassed("", true, "guest", 'net\dryuf\comp\wedding\mvp\WeddingGiftsListPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("propose.html", false, "guest", 'net\dryuf\comp\wedding\mvp\WeddingGiftsProposePresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("coordinator.html", false, "guest", 'net\dryuf\comp\wedding\mvp\WeddingGiftsCoordinatorPresenter', \net\dryuf\core\Options::$NONE)
			));
	}

};

\net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter::_initManualStatic();


?>
