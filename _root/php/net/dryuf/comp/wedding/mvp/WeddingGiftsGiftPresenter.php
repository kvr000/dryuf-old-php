<?php

namespace net\dryuf\comp\wedding\mvp;


class WeddingGiftsGiftPresenter extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->giftsPresenter = $this->getParentPresenter();
		$this->weddingGiftsId = $this->giftsPresenter->getWeddingGiftsId();
		$this->weddingGiftsHeader = $this->giftsPresenter->getWeddingGiftsHeader();
		$this->weddingGiftsGiftDao = $this->giftsPresenter->getWeddingGiftsGiftDao();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setMode($mode)
	{
		$this->giftsPresenter->setMode($mode);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$displayName = $this->getRootPresenter()->getLastElementWithoutSlash();
		$gifts = new \net\dryuf\util\LinkedList();
		$this->weddingGiftsGiftDao->listDynamic($gifts, $this->giftsPresenter->getWeddingGiftsHeaderHolder(), \net\dryuf\util\MapUtil::createStringNativeHashMap("pk.displayName", $displayName), null, null, null);
		if ($gifts->size() != 1) {
			$this->parentPresenter->setLeadChild(null);
			$this->createNotFoundPresenter();
			return true;
		}
		else {
			$this->giftHolder = $gifts->get(0);
			$this->gift = $this->giftHolder->getEntity();
		}
		return self::$divider->process($this);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		$this->outputFormat("<p>%S: %S</p>\n", $this->gift->getName(), $this->gift->getDescription());
		parent::render();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter')
	*/
	protected			$giftsPresenter;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\mvp\WeddingGiftsPresenter')
	*/
	public function			getGiftsPresenter()
	{
		return $this->giftsPresenter;
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
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\wedding\WeddingGiftsGift>')
	*/
	protected			$giftHolder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\wedding\WeddingGiftsGift>')
	*/
	public function			getGiftHolder()
	{
		return $this->giftHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsGift')
	*/
	protected			$gift;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\wedding\WeddingGiftsGift')
	*/
	public function			getGift()
	{
		return $this->gift;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterDivider')
	*/
	public static			$divider;

	public static function		_initManualStatic()
	{
		self::$divider = new \net\dryuf\mvp\StaticPresenterDivider(
			array(
				\net\dryuf\mvp\PresenterElement::createClassed("", true, "guest", 'net\dryuf\mvp\ChildPresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("reserve.html", false, "guest", 'net\dryuf\comp\wedding\mvp\WeddingGiftsReservePresenter', \net\dryuf\core\Options::$NONE),
				\net\dryuf\mvp\PresenterElement::createClassed("cancel.html", false, "guest", 'net\dryuf\comp\wedding\mvp\WeddingGiftsCancelPresenter', \net\dryuf\core\Options::$NONE)
			));
	}

};

\net\dryuf\comp\wedding\mvp\WeddingGiftsGiftPresenter::_initManualStatic();


?>
