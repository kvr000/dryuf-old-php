<?php

namespace net\dryuf\srvui;


class PageUrl extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TYPE_FINAL = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TYPE_RELATIVE = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TYPE_ROOTED = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TYPE_LANGUAGED = 3;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TYPE_PAGED = 4;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TYPE_VIRTUAL = 5;

	/**
	 * Creates PageUrl directly passing the input url and options.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createVirtual($url, $options)
	{
		return new \net\dryuf\srvui\PageUrl(self::TYPE_VIRTUAL, $url, $options);
	}

	/**
	 * Creates direct URL.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createResource($url)
	{
		return substr($url, 0, strlen("/")) == "/" ? \net\dryuf\srvui\PageUrl::createRooted($url) : \net\dryuf\srvui\PageUrl::createRelative($url);
	}

	/**
	 * Creates direct URL.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createFinal($url)
	{
		return new \net\dryuf\srvui\PageUrl(self::TYPE_FINAL, $url, \net\dryuf\core\Options::$NONE);
	}

	/**
	 * Creates direct URL.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createRelative($url)
	{
		return new \net\dryuf\srvui\PageUrl(self::TYPE_RELATIVE, $url, \net\dryuf\core\Options::$NONE);
	}

	/**
	 * Creates root relative URL.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createRooted($url)
	{
		return new \net\dryuf\srvui\PageUrl(self::TYPE_ROOTED, $url, \net\dryuf\core\Options::$NONE);
	}

	/**
	 * Creates page url, i.e. pageCode identifies the name of the page.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createPaged($pageCode)
	{
		return new \net\dryuf\srvui\PageUrl(self::TYPE_PAGED, $pageCode, \net\dryuf\core\Options::$NONE);
	}

	/**
	 * Creates local url, within the current language path.
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		createLanguaged($url)
	{
		return new \net\dryuf\srvui\PageUrl(self::TYPE_LANGUAGED, $url, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageUrl')
	*/
	public static function		getDummy()
	{
		return \net\dryuf\srvui\PageUrl::createFinal("");
	}

	/**
	*/
	function			__construct($type, $url, $options)
	{
		parent::__construct();
		$this->type = $type;
		$this->url = $url;
		$this->options = $options;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getUrl()
	{
		return $this->url;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$url;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getType()
	{
		return $this->type;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$type = 0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	public function			getOptions()
	{
		return $this->options;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\srvui\PageUrl))
			return false;
		$s = $o;
		if ($s->type != $this->type)
			return false;
		if (!is_null($s->url) ? !($s->url === $this->url) : !is_null($this->url))
			return false;
		if (!is_null($s->options) ? !\net\dryuf\core\Dryuf::equalObjects($s->options, $this->options) : !is_null($this->options))
			return false;
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ($this->type*37+(is_null($this->url) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->url)))*37+(is_null($this->options) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->options));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Options')
	*/
	protected			$options;
};


?>
