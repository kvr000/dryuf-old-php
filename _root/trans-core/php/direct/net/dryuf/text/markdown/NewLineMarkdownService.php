<?php

namespace net\dryuf\text\markdown;


/**
 * {@link MarkdownService} which simply converts new lines into paragraphs.
 */
class NewLineMarkdownService extends \net\dryuf\core\Object implements \net\dryuf\text\markdown\MarkdownService
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Integer, java\lang\String>')
	*/
	public function			validateInput($input)
	{
		return new \net\dryuf\util\HashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			convertToXhtml($input)
	{
		return \net\dryuf\core\StringUtil::replaceRegExp(trim(htmlspecialchars($input)), "\\s*\\n\\s*", "<br/>\n");
	}
};


?>
