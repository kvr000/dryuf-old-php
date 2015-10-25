<?php

namespace net\dryuf\textual\test;


/**
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class TextualsTestBase extends \net\dryuf\tenv\AppTenvObject
{
	/**
	*/
	function			__construct($textualClass)
	{
		parent::__construct();
		$this->textualClass = $textualClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		parent::afterAppContainer($appContainer);
		$this->textual = \net\dryuf\textual\TextualManager::createTextual($this->textualClass, $this->createCallerContext());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Textual<java\lang\Object>')
	*/
	protected			$textual;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\core\Textual<java\lang\Object>>')
	*/
	protected			$textualClass;
};


?>
