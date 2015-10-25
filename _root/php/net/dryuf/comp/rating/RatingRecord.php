<?php

namespace net\dryuf\comp\rating;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\rating\RatingRecord\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\rating\RatingHeader', composPkClazz = 'integer', composPath = "pk.ratingId", additionalPkFields = { "userId" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "value" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "Rating.set", roleGet = "Rating.get", roleSet = "Rating.set", roleDel = "Rating.set")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "RatingRecord")
*/
class RatingRecord extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\rating\RatingRecord\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingRecord\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "value")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.set", roleGet = "Rating.get", roleSet = "Rating.set", roleDel = "Rating.set")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$value;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRatingId($ratingId_)
	{
		$this->pk->setRatingId($ratingId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRatingId()
	{
		return $this->pk->getRatingId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId_)
	{
		$this->pk->setUserId($userId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getUserId()
	{
		return $this->pk->getUserId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setValue($value_)
	{
		$this->value = $value_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getValue()
	{
		return $this->value;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingRecord\Pk')
	*/
	public function			getPk()
	{
		return $this->pk;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($pk_)
	{
		$this->pk = $pk_;
	}
};


?>
