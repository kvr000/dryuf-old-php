<?php

namespace net\dryuf\config\db;


class DbIniConfig extends \net\dryuf\core\Object implements \net\dryuf\config\IniConfig
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
	public function			getValueMandatory($section, $name)
	{
		$value = $this->getValueDefault($section, $name, null);
		if (is_null($value))
			throw new \net\dryuf\core\ReportException("key ".$section."/".$name." not found");
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getValueDefault($section, $name, $defaultValue)
	{
		$value = $this->dbConfigEntryDao->loadByPk(new \net\dryuf\config\DbConfigEntry\Pk(new \net\dryuf\config\DbConfigSection\Pk($this->profileName, $section), $name));
		return is_null($value) ? $defaultValue : $value->getConfigValue();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextualMandatory($section, $name, $textual)
	{
		$value = $this->getValueMandatory($section, $name);
		return $textual->convert($value, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextualDefault($section, $name, $textual, $defaultValue)
	{
		$value = $this->getValueDefault($section, $name, null);
		if (is_null($value))
			return $defaultValue;
		return $textual->convert($value, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\ValueConfig')
	*/
	public function			getSection($section)
	{
		return new \net\dryuf\config\AbstractValueConfig($this, $section);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			listSectionKeys($sectionName)
	{
		return (=f_I_x=)Sets.newHashSet(Iterables.transform(dbConfigEntryDao.listByCompos(new DbConfigSection.Pk(profileName, sectionName)), (DbConfigEntry entry)->{
		    return entry.getConfigKey();
		}))(=x_I_f=);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\dao\DbConfigEntryDao')
	*/
	protected			$dbConfigEntryDao;

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\inject\Inject
	*/
	public function			setDbConfigEntryDao($dbConfigEntryDao_)
	{
		$this->dbConfigEntryDao = $dbConfigEntryDao_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$profileName;

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\inject\Inject
	*/
	public function			setProfileName($profileName_)
	{
		$this->profileName = $profileName_;
	}
};


?>
