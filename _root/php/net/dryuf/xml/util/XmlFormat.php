<?php

namespace net\dryuf\xml\util;


class XmlFormat extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\util\function\Function<java\lang\String, java\lang\String>')
	*/
	public static function		escaper()
	{
		return function ($s) {
			return htmlspecialchars($s);
		}
		;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		escapeXml($s)
	{
		return htmlspecialchars($s);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatJsString($s)
	{
		return "\"".\net\dryuf\core\StringUtil::replaceRegExp(\net\dryuf\core\StringUtil::replaceRegExp(\net\dryuf\core\StringUtil::replaceRegExp(\net\dryuf\core\StringUtil::replaceRegExp($s, "\\\\", "\\\\\\\\"), "\"", "\\\\\""), "\n", "\\\\n"), "\t", "\\\\t")."\"";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinEscaped($separator, $input)
	{
		return \net\dryuf\core\StringUtil::joinEscaped(\net\dryuf\xml\util\XmlFormat::escaper(), $separator, $input);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		appendAttributeSb($out, $name, $value)
	{
		$out->append(" ");
		$out->append($name);
		$out->append("=\"");
		$out->append(htmlspecialchars($value));
		$out->append("\"");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		formatStream($outputStream, $callerContext, $fmt)
	{
		$args = func_get_args();
		$out = new \net\dryuf\core\StringBuilder();
		$args[0] = $out;
		call_user_func_array('\net\dryuf\xml\util\XmlFormat::formatSb', $args);
		fwrite($outputStream, strval($out));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		formatSb($out, $callerContext, $fmt)
	{
		$args = func_get_args();
		array_splice($args, 0, 3);
		$ai = 0;
		for ($i = 0; $i < strlen($fmt); $i++) {
			if ($fmt[$i] == '%') {
				switch ($fmt[++$i]) {
				case '%':
					$out->append('%');
					break;

				case 's':
					$out->append($args[$ai++]);
					break;

				case 'S':
					$out->append(htmlspecialchars($args[$ai++]));
					break;

				case 'A':
					$out->append("\"");
					$out->append(htmlspecialchars($args[$ai++]));
					$out->append("\"");
					break;

				case 'K':
					$textual = $args[$ai++];
					$out->append(htmlspecialchars($textual->format($args[$ai++], null)));
					break;

				case 'O':
					$out->append(htmlspecialchars(strval($args[$ai++])));
					break;

				case 'R':
					throw new \net\dryuf\core\RuntimeException("unsupported yet");

				case 'U':
					throw new \net\dryuf\core\RuntimeException("unsupported yet");

				case 'W':
					{
						$msg = $args[$ai++];
						$cls = $args[$ai++];
						$out->append(htmlspecialchars($callerContext->getUiContext()->localize($cls, $msg)));
					}
					break;

				default:
					throw new \net\dryuf\core\RuntimeException("invalid format character: ".substr($fmt, $i-1, 1));
				}
			}
			else {
				$out->append(substr($fmt, $i, 1));
			}
		}
	}
};


?>
