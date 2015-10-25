<?php

namespace net\dryuf\textual;


class AbstractTextual extends \net\dryuf\core\Object implements \net\dryuf\core\Textual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Textual<java\lang\Object>')
	*/
	public function			setCallerContext($callerContext)
	{
		if (is_null(($this->callerContext = $callerContext)))
			throw new \net\dryuf\core\NullPointerException();
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			prepare($text, $style)
	{
		return $text;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			check($text, $style)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertInternal($text, $style)
	{
		return $text;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convert($text, $style)
	{
		$result = $this->convertInternal($text, $style);
		if (!is_null(($err = $this->validate($result))))
			throw new \net\dryuf\core\RuntimeException($err);
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return is_null($internal) ? "" : strval($internal);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertKey($text)
	{
		$result = $this->convertKeyInternal($text);
		if (!is_null(($error = $this->validate($result))))
			throw new \net\dryuf\core\RuntimeException($error);
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertKeyInternal($text)
	{
		return $this->convertInternal($text, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatKey($internal)
	{
		return $this->format($internal, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\UiContext')
	*/
	protected function		getUiContext()
	{
		return $this->callerContext->getUiContext();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected function		getCallerContext()
	{
		return $this->callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;
};


?>
