<?php

namespace net\dryuf\comp\rating;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "ratingId", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "ratingId", "refBase", "refKey", "total", "counts", "rating" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "Rating.set", roleDel = "Rating.del")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "RatingHeader")
*/
class RatingHeader extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "ratingId")
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "_denied_", roleDel = "Rating.del")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$ratingId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refBase")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "Rating.set", roleDel = "Rating.del")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refBase;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "refKey")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "Rating.set", roleDel = "Rating.del")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$refKey;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "total")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "Rating.set", roleDel = "Rating.del")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$total = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "counts")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "Rating.set", roleDel = "Rating.del")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$counts = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "rating")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Rating.new", roleGet = "Rating.set", roleSet = "Rating.set", roleDel = "Rating.del")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$rating = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->ratingId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($ratingId_)
	{
		$this->ratingId = $ratingId_;
	}

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
	public function			setRefBase($refBase_)
	{
		$this->refBase = $refBase_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRefBase()
	{
		return $this->refBase;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRefKey($refKey_)
	{
		$this->refKey = $refKey_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRefKey()
	{
		return $this->refKey;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTotal($total_)
	{
		$this->total = $total_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getTotal()
	{
		return $this->total;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setCounts($counts_)
	{
		$this->counts = $counts_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCounts()
	{
		return $this->counts;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRating($rating_)
	{
		$this->rating = $rating_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getRating()
	{
		return $this->rating;
	}
};


?>
