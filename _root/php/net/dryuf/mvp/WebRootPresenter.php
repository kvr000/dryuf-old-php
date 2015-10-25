<?php

namespace net\dryuf\mvp;


class WebRootPresenter extends \net\dryuf\mvp\RootPresenter
{
	/**
	*/
	function			__construct($callerContext_, $request_)
	{
		parent::__construct($callerContext_, $request_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContextPath()
	{
		return $this->getRequest()->getContextPath();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			escapeText($text)
	{
		return htmlspecialchars($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createNotFoundPresenter()
	{
		return new \net\dryuf\mvp\NotFoundPresenter(new \net\dryuf\mvp\EmptyXhtmlPresenter($this, \net\dryuf\core\Options::$NONE), \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDeniedPresenter()
	{
		return new \net\dryuf\mvp\DeniedPresenter(new \net\dryuf\mvp\EmptyXhtmlPresenter($this, \net\dryuf\core\Options::$NONE), \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createUnallowedMethodPresenter()
	{
		return new \net\dryuf\mvp\UnallowedMethodPresenter(new \net\dryuf\mvp\EmptyXhtmlPresenter($this, \net\dryuf\core\Options::$NONE), \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			output($text)
	{
		fputs($this->output, $text);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			outputFormat($fmt)
	{
		$args = func_get_args();
		$format = array_shift($args);
		while (($p = strpos($format, '%')) !== false) {
			if (substr($format, $p+1, 1) == '%') {
				fputs($this->output, substr($format, 0, $p+1));
				$format = substr($format, $p+2);
				continue;
			}
			elseif ($p > 0) {
				fputs($this->output, substr($format, 0, $p));
			}
			$fc = substr($format, $p+1, 1);
			$format = substr($format, $p+2);
			switch ($fc) {
			case '%':
				fputs($this->output, "%");
				break;

			case 's':
				fputs($this->output, array_shift($args));
				break;

			case 'S':
				fputs($this->output, htmlspecialchars(array_shift($args)));
				break;

			case 'A':
				fputs($this->output, "\"".htmlspecialchars(array_shift($args))."\"");
				break;

			case 'E':
				fputs($this->output, htmlspecialchars(urlencode(array_shift($args))));
				break;

			case 'J':
				fputs($this->output, json_encode(strval(array_shift($args))));
				break;
 
			case 'K':
				$textual = array_shift($args);
				fputs($this->output, htmlspecialchars($textual->format(array_shift($args), null)));
				break;

			case 'R':
				fputs($this->output, htmlspecialchars($this->stringifyRef(array_shift($args))));
				break;

			case 'U':
				fputs($this->output, htmlspecialchars($this->stringifyRef(array_shift($args))));
				break;

			/*
			case 'V':
				fputs($this->output, htmlspecialchars($this->localize(array_shift($args), null)));
				break;
			 */
				
			case 'W':
				fputs($this->output, htmlspecialchars($this->localize(array_shift($args), array_shift($args))));
				break;

			default:
				throw new \net\dryuf\core\RuntimeException("invalid format character: $fc");
			}
		}
		fputs($this->output, $format);
	}
};


?>
