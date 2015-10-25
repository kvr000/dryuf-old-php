<?php

namespace net\dryuf\mvp\proc;


class VarsPresenter extends \net\dryuf\mvp\FinalEmptyTextPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			process()
	{
		$this->remainPath = $this->getRootPresenter()->getRemainPath();
		return $this->processFinal();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			render()
	{
		echo var_export($_SERVER, 1);
		echo "\n";
		$this->output("Remaining path: ".$this->remainPath);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$remainPath;
};


?>
