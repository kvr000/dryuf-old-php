<?php

namespace net\dryuf\comp\rating\RatingRecord;


/**
@\net\dryuf\meta\FieldOrder(fields = { "ratingId", "userId" })
@\net\dryuf\meta\FieldRoles(roleNew = "Rating.set", roleGet = "Rating.get", roleSet = "Rating.set", roleDel = "Rating.set")
@\javax\persistence\Embeddable
*/
class Pk extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRatingId($ratingId_)
	{
		$this->ratingId = $ratingId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRatingId()
	{
		return $this->ratingId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId_)
	{
		$this->userId = $userId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getUserId()
	{
		return $this->userId;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "ratingId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "Rating.get", roleSet = "_denied_", roleDel = "Rating.set")
	*/
	protected			$ratingId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "userId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.set", roleGet = "Rating.get", roleSet = "_denied_", roleDel = "Rating.set")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$userId;

	/**
	*/
	function			__construct($ratingId = null, $userId = null)
	{
		parent::__construct();
		$this->ratingId = $ratingId;
		$this->userId = $userId;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->ratingId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->ratingId)))*37+(is_null($this->userId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->userId));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\comp\rating\RatingRecord\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->ratingId) ? is_null($s->ratingId) : ($this->ratingId === $s->ratingId)) && (is_null($this->userId) ? is_null($s->userId) : ($this->userId === $s->userId));
	}
};


?>
