<?php

namespace net\dryuf\srvui;


abstract class AbstractRequest extends \net\dryuf\core\Object implements \net\dryuf\srvui\Request
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getParamMandatory($param)
	{
		if (is_null(($value = $this->getParam($param))))
			throw new \net\dryuf\core\ReportException("param ".$param." not found");
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getParamDefault($param, $defaultValue)
	{
		$value = $this->getParam($param);
		return is_null($value) ? $defaultValue : $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextual($param, $textual)
	{
		if (is_null(($value = $this->getParam($param))))
			return null;
		try {
			return $textual->convert($value, null);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("failed to convert param ".$param.": ".$ex->getMessage(), $ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextualDefault($param, $textual, $defaultValue)
	{
		if (is_null(($value = $this->getParam($param))))
			return $defaultValue;
		try {
			return $textual->convert($value, null);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("failed to convert param ".$param.": ".$ex->getMessage(), $ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextualMandatory($param, $textual)
	{
		$value = $this->getParamMandatory($param);
		try {
			return $textual->convert($value, null);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException("failed to convert param ".$param.": ".$ex->getMessage(), $ex);
		}
	}
};


?>
