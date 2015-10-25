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
	public function			outputFormat($fmt, $args)
	{
		$sb = new \net\dryuf\core\StringBuilder();
		$ai = 0;
		for ($i = 0; $i < strlen($fmt); $i++) {
			if (substr($fmt, $i, 1) == '%') {
				switch (substr($fmt, ++$i, 1)) {
				case '%':
					$sb->append('%');
					break;

				case 's':
					$sb->append($args[$ai++]);
					break;

				case 'S':
					$sb->append($this->escapeText($args[$ai++]));
					break;

				case 'A':
					$sb->append("\"");
					$sb->append($args[$ai++]);
					$sb->append("\"");
					break;

				case 'K':
					$textual = $args[$ai++];
					$sb->append($this->escapeText($textual->format($args[$ai++], null)));
					break;

				case 'O':
					$sb->append($this->escapeText(strval($args[$ai++])));
					break;

				case 'R':
					throw new \net\dryuf\core\RuntimeException("unsupported yet");

				case 'U':
					throw new \net\dryuf\core\RuntimeException("unsupported yet");

				case 'W':
					{
						$cls = $args[$ai++];
						$msg = $args[$ai++];
						$sb->append($this->escapeText($this->uiContext->localize($cls, $msg)));
					}
					break;

				default:
					throw new \net\dryuf\core\RuntimeException("invalid format character: ".substr($fmt, $i-1, 1));
				}
			}
			else {
				$sb->append(substr($fmt, $i, 1));
			}
		}
		$this->output(strval($sb));
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
