<?php

namespace net\dryuf\mvp;


abstract class CommonRootPresenter extends \net\dryuf\mvp\RootPresenter
{
	/**
	*/
	function			__construct($callerContext, $request)
	{
		parent::__construct($callerContext, $request);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			initUiContext($contextPath)
	{
		$this->getUiContext()->setLocalizeContextPath($contextPath);
		$this->uiContext->setLanguage($this->request->getParamDefault("lang", $this->uiContext->getDefaultLanguage()));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	public function			getSession()
	{
		return $this->getRequest()->getSession();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\Session')
	*/
	public function			forceSession()
	{
		return $this->getRequest()->forceSession();
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
				$this->output(substr($format, 0, $p+1));
				$format = substr($format, $p+2);
				continue;
			}
			elseif ($p > 0) {
				$this->output(substr($format, 0, $p));
			}
			$fc = substr($format, $p+1, 1);
			$format = substr($format, $p+2);
			switch ($fc) {
			case '%':
				$this->output("%");
				break;

			case 's':
				$this->output(array_shift($args));
				break;

			case 'S':
				$this->output(htmlspecialchars(array_shift($args)));
				break;

			case 'A':
				$this->output("\"".htmlspecialchars(array_shift($args))."\"");
				break;

			case 'E':
				$sb->append(htmlspecialchars(urlencode($args[$ai++])));
				break;

			case 'K':
				$textual = array_shift($args);
				$this->output(htmlspecialchars($textual->format(array_shift($args), null)));
				break;

			case 'R':
				$this->output(htmlspecialchars($this->stringifyRef(array_shift($args))));
				break;

			case 'U':
				$this->output(htmlspecialchars($this->stringifyRef(array_shift($args))));
				break;

			/*
			case 'V':
				$this->output(htmlspecialchars($this->localize(array_shift($args), null)));
				break;
			 */
				
			case 'W':
				$this->output(htmlspecialchars($this->localize(array_shift($args), array_shift($args))));
				break;

			default:
				throw new \net\dryuf\core\Exception("invalid format character: $fc");
			}
		}
		$this->output($format);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			escapeText($text)
	{
		return $text;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createNotFoundPresenter()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("NotFoundPresenter unsupported");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createDeniedPresenter()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("DeniedPresenter unsupported");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createUnallowedMethodPresenter()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("UnallowedMethodPresenter unsupported");
	}
};


?>
