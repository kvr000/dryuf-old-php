<?php

namespace net\dryuf\comp\poll;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "Poll.update"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "Poll.update"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, guiDef = "target=this", roleAction = "Poll.update")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\comp\poll\PollOption\Pk', pkField = "pk", composClazz = 'net\dryuf\comp\poll\PollHeader', composPkClazz = 'integer', composPath = "pk.pollId", additionalPkFields = { "optionId" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "description", "voteCount" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\RefFieldsDef(fields = { "optionId", "description" })
@\net\dryuf\meta\FieldRoles(roleNew = "Poll.update", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "PollOption")
*/
class PollOption extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\comp\poll\PollOption\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollOption\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "description")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "Poll.update", roleGet = "Poll.get", roleSet = "Poll.update", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$description;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "voteCount")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "Poll.get", roleSet = "extreme", roleDel = "Poll.update")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$voteCount = 0;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPollId($pollId_)
	{
		$this->pk->setPollId($pollId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPollId()
	{
		return $this->pk->getPollId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setOptionId($optionId_)
	{
		$this->pk->setOptionId($optionId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			getOptionId()
	{
		return $this->pk->getOptionId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDescription($description_)
	{
		$this->description = $description_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDescription()
	{
		return $this->description;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setVoteCount($voteCount_)
	{
		$this->voteCount = $voteCount_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getVoteCount()
	{
		return $this->voteCount;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollOption\Pk')
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
