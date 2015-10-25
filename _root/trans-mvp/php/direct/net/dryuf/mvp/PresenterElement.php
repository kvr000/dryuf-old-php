<?php

namespace net\dryuf\mvp;


class PresenterElement extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($page, $needSlash, $requiredRole, $creator)
	{
		parent::__construct();
		$this->page = $page;
		$this->needSlash = $needSlash;
		$this->requiredRole = $requiredRole;
		$this->creator = $creator;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterElement')
	*/
	public static function		createClassed($page, $needSlash, $requiredRole, $presenterClass, $options)
	{
		try {
			$constructor = (=f_I_x=)presenterClass.getConstructor(Presenter.class, Options.class)(=x_I_f=);
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		return new \net\dryuf\mvp\PresenterElement($page, $needSlash, $requiredRole, 
			function ($parentPresenter) use ($options, $constructor) {
				try {
					return $constructor->newInstance($parentPresenter, $options)->init();
				}
				catch (\net\dryuf\core\Exception $e) {
					throw new \net\dryuf\core\RuntimeException($e);
				}
			}
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\PresenterElement')
	*/
	public static function		createFunction($page, $needSlash, $requiredRole, $creator)
	{
		return new \net\dryuf\mvp\PresenterElement($page, $needSlash, $requiredRole, $creator);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$page;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPage()
	{
		return $this->page;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$needSlash = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			getNeedSlash()
	{
		return $this->needSlash;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$requiredRole;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRequiredRole()
	{
		return $this->requiredRole;
	}

	/**
	@\net\dryuf\core\Type(type = 'com\google\common\base\Function<net\dryuf\mvp\Presenter, net\dryuf\mvp\Presenter>')
	*/
	protected			$creator;

	/**
	@\net\dryuf\core\Type(type = 'com\google\common\base\Function<net\dryuf\mvp\Presenter, net\dryuf\mvp\Presenter>')
	*/
	public function			getCreator()
	{
		return $this->creator;
	}
};


?>
