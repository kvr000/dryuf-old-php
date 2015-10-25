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
		$this->getResponse()->getWriter()->print($text);
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
					$sb->append(htmlspecialchars($args[$ai++]));
					break;

				case 'A':
					$sb->append("\"");
					$sb->append(htmlspecialchars($args[$ai++]));
					$sb->append("\"");
					break;

				case 'E':
					$sb->append(htmlspecialchars(\net\dryuf\net\util\UrlUtil::encodeUrl($args[$ai++])));
					break;

				case 'J':
					$sb->append(\net\dryuf\xml\util\XmlFormat::formatJsString($args[$ai++]));
					break;

				case 'K':
					$textual = $args[$ai++];
					$sb->append(htmlspecialchars($textual->format($args[$ai++], null)));
					break;

				case 'O':
					$sb->append(htmlspecialchars(strval($args[$ai++])));
					break;

				case 'R':
					throw new \net\dryuf\core\RuntimeException("unsupported yet");

				case 'U':
					{
						$url = $this->stringifyRef($args[$ai++]);
						$sb->append(htmlspecialchars($url));
					}
					break;

				case 'W':
					{
						$cls = $args[$ai++];
						$msg = $args[$ai++];
						$sb->append(htmlspecialchars($cls instanceof \java\lang\Class ? $this->uiContext->localize($cls, $msg) : $this->uiContext->localize($cls, $msg)));
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
};


?>
